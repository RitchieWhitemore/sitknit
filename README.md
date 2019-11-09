
DIRECTORY STRUCTURE
-------------------

      assets/             contains assets definition
      commands/           contains console commands (controllers)
      config/             contains application configurations
      controllers/        contains Web controller classes
      mail/               contains view files for e-mails
      models/             contains model classes
      runtime/            contains files generated during runtime
      tests/              contains various tests for the basic application
      vendor/             contains dependent 3rd-party packages
      views/              contains view files for the Web application
      web/                contains the entry script and Web resources



Сборка проекта Polymer

компонент устанавливается с помощью команды
npm install --save @polymer/paper-spinner

Компонент импортируется в index.html для сборки polymer build

запускаем polymer build

копируем npm_modules из /build/prod/ в /web

-----------------------------------------

docker-compose exec php bash