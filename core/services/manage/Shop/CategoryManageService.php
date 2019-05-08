<?php


namespace app\core\services\manage\Shop;


use app\core\entities\Shop\Category;
use app\core\forms\manage\Shop\CategoryForm;
use app\core\repositories\Shop\CategoryRepository;

class CategoryManageService
{
    private $categories;

    public function __construct(CategoryRepository $categories)
    {
        $this->categories = $categories;
    }

    public function create(CategoryForm $form): Category
    {
        $parent = $this->categories->get($form->parentId);
        $category = Category::create(
            $form->name,
            $form->slug,
            $form->title,
            $form->description
        );

        $category->image = $form->imageFile;

        $category->appendTo($parent);
        $this->categories->save($category);
        return $category;
    }

    public function edit($id, CategoryForm $form)
    {
        $category = $this->categories->get($id);
        $this->assertIsNotRoot($category);
        $category->edit(
            $form->name,
            $form->slug,
            $form->title,
            $form->description
        );

        $category->image = $form->imageFile;

        if ($form->parentId !== $category->parent->id) {
            $parent = $this->categories->get($form->parentId);
            $category->appendTo($parent);
        }
        $this->categories->save($category);
    }

    public function remove($id)
    {
        $category = $this->categories->get($id);
        $this->assertIsNotRoot($category);
        /*if ($this->products->existsByMainCategory($category->id)) {
            throw new \DomainException('Unable to remove category with products.');
        }*/
        $this->categories->remove($category);
    }

    public function moveUp($id)
    {
        $category = $this->categories->get($id);

        $this->assertIsNotRoot($category);

        if ($prev = $category->prev) {
            $category->insertBefore($prev);
        }

        $this->categories->save($category);
    }

    public function moveDown($id)
    {
        $category = $this->categories->get($id);

        $this->assertIsNotRoot($category);

        if ($next = $category->next) {
            $category->insertAfter($next);
        }

        $this->categories->save($category);
    }

    private function assertIsNotRoot(Category $category)
    {
        if ($category->isRoot()) {
            throw new \DomainException('Unable to manage the root category.');
        }
    }
}