<!--- BEGIN HEADER -->
# Changelog

All notable changes to this project will be documented in this file.
<!--- END HEADER -->

<a name="unreleased"></a>
## [Unreleased]


<a name="3.18.0"></a>
## [3.18.0] - 2025-03-01
### CI
- **config:** Remove friendly error formatting in PHPStan config
- **dependencies:** Add PHPStan extensions and update composer.json
- **workflows:** Update PHP and Laravel versions in tests.yml

### Feat
- **dependencies:** Update Composer package versions and options

### Pull Requests
- Merge pull request [#59](https://github.com/guanguans/laravel-soar/issues/59) from guanguans/dependabot/github_actions/dependabot/fetch-metadata-2.3.0


<a name="3.17.0"></a>
## [3.17.0] - 2025-01-17
### CI
- **config:** Update PHPStan and Psalm configurations

### Docs
- **README:** Update badge links in the README file

### Feat
- **ScoreCommand:** Read SQL from standard input if available

### Pull Requests
- Merge pull request [#58](https://github.com/guanguans/laravel-soar/issues/58) from guanguans/dependabot/composer/guanguans/soar-php-tw-5.0


<a name="3.16.3"></a>
## [3.16.3] - 2024-08-16
### CI
- **rector:** add new rules for Rector configuration

### Feat
- **dependencies:** update development dependencies versions

### Perf
- **bootstrapper:** Optimize sprintf usage

### Pull Requests
- Merge pull request [#56](https://github.com/guanguans/laravel-soar/issues/56) from guanguans/dependabot/github_actions/dependabot/fetch-metadata-2.2.0


<a name="3.16.2"></a>
## [3.16.2] - 2024-06-17
### Fix
- **OutputConditions:** Improve content checking in isHtmlResponse and isJsonResponse

### Pull Requests
- Merge pull request [#54](https://github.com/guanguans/laravel-soar/issues/54) from guanguans/imgbot


<a name="3.16.1"></a>
## [3.16.1] - 2024-06-11
### Docs
- **readme:** update available commands section

### Feat
- **commands.tape:** add new commands and update existing commands
- **commands.tape:** add commands tape for recording commands

### Refactor
- **commands:** Update output method in WithSoarOptions trait

### Test
- Add RunCommandTest and update ScoreCommandTest


<a name="3.16.0"></a>
## [3.16.0] - 2024-06-07
### Feat
- **commands:** Add RunCommand

### Refactor
- **commands:** Refactor ScoreCommand handle method
- **score:** Improve Soar score command signature and options handling


<a name="3.15.1"></a>
## [3.15.1] - 2024-06-07
### Refactor
- **commands:** improve input handling in ScoreCommand


<a name="3.15.0"></a>
## [3.15.0] - 2024-06-06
### Feat
- **commands:** Add ScoreCommand class
- **config:** Add parallel config for PHP-CS-Fixer

### Test
- **commands:** add test for ScoreCommand


<a name="3.14.2"></a>
## [3.14.2] - 2024-06-06
### Pull Requests
- Merge pull request [#53](https://github.com/guanguans/laravel-soar/issues/53) from guanguans/dependabot/github_actions/dependabot/fetch-metadata-2.1.0


<a name="3.14.1"></a>
## [3.14.1] - 2024-04-01
### CI
- Added SoarTest.php to test LaravelSoar facade

### Feat
- **Soar.php:** Implement dynamic method calls and remove Conditionable trait


<a name="3.14.0"></a>
## [3.14.0] - 2024-04-01

<a name="3.13.0"></a>
## [3.13.0] - 2024-04-01
### Docs
- **readme:** Update README files with code snippet

### Refactor
- **core:** Remove redundant code and update middleware registration


<a name="3.12.1"></a>
## [3.12.1] - 2024-04-01
### CI
- **tests:** Add Clover.xml file for Codecov upload

### Refactor
- **README:** update code comments

### Pull Requests
- Merge pull request [#52](https://github.com/guanguans/laravel-soar/issues/52) from guanguans/dependabot/github_actions/dependabot/fetch-metadata-2.0.0
- Merge pull request [#51](https://github.com/guanguans/laravel-soar/issues/51) from guanguans/dependabot/github_actions/dependabot/fetch-metadata-1.7.0


<a name="3.12.0"></a>
## [3.12.0] - 2024-03-13
### Pull Requests
- Merge pull request [#49](https://github.com/guanguans/laravel-soar/issues/49) from guanguans/dependabot/github_actions/codecov/codecov-action-4
- Merge pull request [#50](https://github.com/guanguans/laravel-soar/issues/50) from guanguans/dependabot/composer/rector/rector-tw-1.0
- Merge pull request [#48](https://github.com/guanguans/laravel-soar/issues/48) from guanguans/dependabot/github_actions/actions/cache-4


<a name="3.11.0"></a>
## [3.11.0] - 2024-01-16
### Fix
- **composer-fixer:** remove dry-run option from normalize command

### Refactor
- Update Soar binary path in code and config
- **config:** Update SoarServiceProvider.php

### Pull Requests
- Merge pull request [#47](https://github.com/guanguans/laravel-soar/issues/47) from guanguans/dependabot/composer/guanguans/soar-php-tw-4.0
- Merge pull request [#46](https://github.com/guanguans/laravel-soar/issues/46) from guanguans/dependabot/composer/rector/rector-tw-0.19


<a name="3.10.1"></a>
## [3.10.1] - 2024-01-07
### Test
- **Feature:** add test for outputting console


<a name="3.10.0"></a>
## [3.10.0] - 2024-01-07
### Refactor
- **config:** exclude telescope commands and URLs from soar scoring
- **output:** implement shouldOutput method


<a name="3.9.1"></a>
## [3.9.1] - 2024-01-04
### Docs
- **README:** update check & fix styling badge link

### Refactor
- **monorepo-builder:** update release workers

### Pull Requests
- Merge pull request [#45](https://github.com/guanguans/laravel-soar/issues/45) from guanguans/dependabot/github_actions/actions/stale-9
- Merge pull request [#44](https://github.com/guanguans/laravel-soar/issues/44) from guanguans/dependabot/github_actions/actions/labeler-5


<a name="3.9.0"></a>
## [3.9.0] - 2023-10-18
### Fix
- **.php-cs-fixer:** update curly_braces_position

### Refactor
- **Bootstrapper:** improve toSql method

### Pull Requests
- Merge pull request [#43](https://github.com/guanguans/laravel-soar/issues/43) from guanguans/dependabot/github_actions/stefanzweifel/git-auto-commit-action-5
- Merge pull request [#42](https://github.com/guanguans/laravel-soar/issues/42) from guanguans/dependabot/github_actions/codecov/codecov-action-4
- Merge pull request [#41](https://github.com/guanguans/laravel-soar/issues/41) from guanguans/dependabot/github_actions/actions/checkout-4


<a name="3.8.3"></a>
## [3.8.3] - 2023-08-30
### Docs
- Update README.md with Chinese translation link

### Feat
- **facade:** Add facade.php file

### Fix
- **QueryAnalyzer:** Fix anonymous function parameter type

### Refactor
- **tests:** update OutputTest.php

### Test
- **OutputTest:** Update console output functionality
- **TestCase.php:** Add Mockery integration

### Pull Requests
- Merge pull request [#40](https://github.com/guanguans/laravel-soar/issues/40) from guanguans/dependabot/composer/rector/rector-tw-0.18


<a name="3.8.2"></a>
## [3.8.2] - 2023-07-27
### Docs
- **composer:** Update composer.json suggestions

### Fix
- **Bootstrapper:** return correct SQL string


<a name="3.8.1"></a>
## [3.8.1] - 2023-07-24
### Fix
- **AssetController:** Fix font file path


<a name="3.8.0"></a>
## [3.8.0] - 2023-07-23
### Feat
- **composer.json:** add monorepo-builder-worker package

### Refactor
- **tests:** Update function names in QueryBuilderMacroTest


<a name="v3.7.1"></a>
## [v3.7.1] - 2023-07-16
### Fix
- **routes:** Update route namespace in web.php


<a name="v3.7.0"></a>
## [v3.7.0] - 2023-07-16
### Feat
- **commands:** add ClearCommand

### Refactor
- **rector.php:** Remove unused rules

### Test
- **commands:** Add ClearCommandTest


<a name="v3.6.1"></a>
## [v3.6.1] - 2023-07-14
### Feat
- **composer.json:** Add facades-lint and facades-update commands

### Refactor
- **JsonOutput:** update data assignment
- **ServiceProvider:** Improve SoarServiceProvider


<a name="v3.6.0"></a>
## [v3.6.0] - 2023-07-14

<a name="v3.5.2"></a>
## [v3.5.2] - 2023-06-30
### Feat
- **composer.json:** Add new dependencies

### Pull Requests
- Merge pull request [#38](https://github.com/guanguans/laravel-soar/issues/38) from guanguans/dependabot/github_actions/dependabot/fetch-metadata-1.6.0


<a name="v3.5.1"></a>
## [v3.5.1] - 2023-06-19

<a name="v3.5.0"></a>
## [v3.5.0] - 2023-06-18

<a name="v3.4.2"></a>
## [v3.4.2] - 2023-06-17

<a name="v3.4.1"></a>
## [v3.4.1] - 2023-06-16

<a name="v3.4.0"></a>
## [v3.4.0] - 2023-06-16

<a name="v3.3.0"></a>
## [v3.3.0] - 2023-06-16

<a name="v3.2.0"></a>
## [v3.2.0] - 2023-06-16

<a name="v3.1.1"></a>
## [v3.1.1] - 2023-06-16
### Pull Requests
- Merge pull request [#37](https://github.com/guanguans/laravel-soar/issues/37) from guanguans/imgbot


<a name="v3.1.0"></a>
## [v3.1.0] - 2023-06-05

<a name="v3.0.2"></a>
## [v3.0.2] - 2023-06-05

<a name="v3.0.1"></a>
## [v3.0.1] - 2023-06-04

<a name="v3.0.0"></a>
## [v3.0.0] - 2023-06-04

<a name="v3.0.0-RC1"></a>
## [v3.0.0-RC1] - 2023-06-04
### Pull Requests
- Merge pull request [#36](https://github.com/guanguans/laravel-soar/issues/36) from guanguans/dependabot/composer/rector/rector-tw-0.17


<a name="v3.0.0-BETA1"></a>
## [v3.0.0-BETA1] - 2023-05-29
### Pull Requests
- Merge pull request [#35](https://github.com/guanguans/laravel-soar/issues/35) from guanguans/3.x


<a name="v2.3.1"></a>
## [v2.3.1] - 2023-05-27

<a name="v2.3.0"></a>
## [v2.3.0] - 2023-03-25

<a name="v2.2.1"></a>
## [v2.2.1] - 2023-02-14

<a name="v2.2.0"></a>
## [v2.2.0] - 2023-02-14
### Pull Requests
- Merge pull request [#29](https://github.com/guanguans/laravel-soar/issues/29) from guanguans/dependabot/composer/vimeo/psalm-tw-5.0


<a name="v2.1.3"></a>
## [v2.1.3] - 2022-06-30

<a name="v2.1.2"></a>
## [v2.1.2] - 2022-06-30

<a name="v2.1.1"></a>
## [v2.1.1] - 2022-06-30

<a name="v2.1.0"></a>
## [v2.1.0] - 2022-04-29
### Pull Requests
- Merge pull request [#26](https://github.com/guanguans/laravel-soar/issues/26) from guanguans/imgbot


<a name="v2.0.12"></a>
## [v2.0.12] - 2022-04-20

<a name="v2.0.11"></a>
## [v2.0.11] - 2022-04-20

<a name="v2.0.10"></a>
## [v2.0.10] - 2022-04-20
### Pull Requests
- Merge pull request [#25](https://github.com/guanguans/laravel-soar/issues/25) from guanguans/imgbot


<a name="v2.0.9"></a>
## [v2.0.9] - 2022-04-18

<a name="v2.0.8"></a>
## [v2.0.8] - 2022-04-18
### Pull Requests
- Merge pull request [#24](https://github.com/guanguans/laravel-soar/issues/24) from guanguans/imgbot


<a name="v2.0.7"></a>
## [v2.0.7] - 2022-04-17
### Pull Requests
- Merge pull request [#23](https://github.com/guanguans/laravel-soar/issues/23) from guanguans/imgbot


<a name="v2.0.6"></a>
## [v2.0.6] - 2022-04-16

<a name="v2.0.5"></a>
## [v2.0.5] - 2022-04-15

<a name="v2.0.4"></a>
## [v2.0.4] - 2022-04-15

<a name="v2.0.3"></a>
## [v2.0.3] - 2022-04-15

<a name="v2.0.2"></a>
## [v2.0.2] - 2022-04-14

<a name="v2.0.1"></a>
## [v2.0.1] - 2022-04-14

<a name="v2.0.0"></a>
## [v2.0.0] - 2022-04-13

<a name="v1.3.2"></a>
## [v1.3.2] - 2022-03-27
### Pull Requests
- Merge pull request [#21](https://github.com/guanguans/laravel-soar/issues/21) from guanguans/dependabot/github_actions/actions/cache-3
- Merge pull request [#20](https://github.com/guanguans/laravel-soar/issues/20) from guanguans/dependabot/github_actions/actions/checkout-3


<a name="v1.3.1"></a>
## [v1.3.1] - 2022-02-22

<a name="v1.3.0"></a>
## [v1.3.0] - 2022-02-14

<a name="v1.2.3"></a>
## [v1.2.3] - 2021-11-30
### Pull Requests
- Merge pull request [#19](https://github.com/guanguans/laravel-soar/issues/19) from guanguans/dependabot/composer/overtrue/phplint-tw-4.0.0


<a name="v1.2.2"></a>
## [v1.2.2] - 2021-11-04
### Pull Requests
- Merge pull request [#18](https://github.com/guanguans/laravel-soar/issues/18) from guanguans/dependabot/composer/guanguans/laravel-dump-sql-tw-2.0


<a name="v1.2.1"></a>
## [v1.2.1] - 2021-10-24

<a name="v1.2.0"></a>
## [v1.2.0] - 2021-10-08

<a name="v1.1.2"></a>
## [v1.1.2] - 2021-09-28
### Pull Requests
- Merge pull request [#16](https://github.com/guanguans/laravel-soar/issues/16) from guanguans/dependabot/composer/friendsofphp/php-cs-fixer-tw-3.1
- Merge pull request [#15](https://github.com/guanguans/laravel-soar/issues/15) from guanguans/dependabot/composer/overtrue/phplint-tw-3.0
- Merge pull request [#14](https://github.com/guanguans/laravel-soar/issues/14) from guanguans/dependabot/composer/orchestra/testbench-tw-6.21
- Merge pull request [#13](https://github.com/guanguans/laravel-soar/issues/13) from guanguans/dependabot/composer/vimeo/psalm-tw-4.10
- Merge pull request [#12](https://github.com/guanguans/laravel-soar/issues/12) from guanguans/dependabot/github_actions/codecov/codecov-action-2.1.0
- Merge pull request [#11](https://github.com/guanguans/laravel-soar/issues/11) from zhonghaibin/master


<a name="v1.1.1"></a>
## [v1.1.1] - 2021-06-17
### Pull Requests
- Merge pull request [#9](https://github.com/guanguans/laravel-soar/issues/9) from guanguans/imgbot


<a name="v1.1.0"></a>
## [v1.1.0] - 2021-06-14
### Pull Requests
- Merge pull request [#8](https://github.com/guanguans/laravel-soar/issues/8) from guanguans/imgbot


<a name="v1.0.3"></a>
## [v1.0.3] - 2021-04-29
### CI
- Add some CI config files

### Docs
- Add comment docs for facade


<a name="v1.0.2"></a>
## [v1.0.2] - 2021-04-25
### CI
- Update some CI config files

### Docs
- Update README.md


<a name="v1.0.1"></a>
## [v1.0.1] - 2020-10-19

<a name="v1.0.0"></a>
## v1.0.0 - 2020-06-27
### Pull Requests
- Merge pull request [#1](https://github.com/guanguans/laravel-soar/issues/1) from guanguans/add-license-1


[Unreleased]: https://github.com/guanguans/laravel-soar/compare/3.18.0...HEAD
[3.18.0]: https://github.com/guanguans/laravel-soar/compare/3.17.0...3.18.0
[3.17.0]: https://github.com/guanguans/laravel-soar/compare/3.16.3...3.17.0
[3.16.3]: https://github.com/guanguans/laravel-soar/compare/3.16.2...3.16.3
[3.16.2]: https://github.com/guanguans/laravel-soar/compare/3.16.1...3.16.2
[3.16.1]: https://github.com/guanguans/laravel-soar/compare/3.16.0...3.16.1
[3.16.0]: https://github.com/guanguans/laravel-soar/compare/3.15.1...3.16.0
[3.15.1]: https://github.com/guanguans/laravel-soar/compare/3.15.0...3.15.1
[3.15.0]: https://github.com/guanguans/laravel-soar/compare/3.14.2...3.15.0
[3.14.2]: https://github.com/guanguans/laravel-soar/compare/3.14.1...3.14.2
[3.14.1]: https://github.com/guanguans/laravel-soar/compare/3.14.0...3.14.1
[3.14.0]: https://github.com/guanguans/laravel-soar/compare/3.13.0...3.14.0
[3.13.0]: https://github.com/guanguans/laravel-soar/compare/3.12.1...3.13.0
[3.12.1]: https://github.com/guanguans/laravel-soar/compare/3.12.0...3.12.1
[3.12.0]: https://github.com/guanguans/laravel-soar/compare/3.11.0...3.12.0
[3.11.0]: https://github.com/guanguans/laravel-soar/compare/3.10.1...3.11.0
[3.10.1]: https://github.com/guanguans/laravel-soar/compare/3.10.0...3.10.1
[3.10.0]: https://github.com/guanguans/laravel-soar/compare/3.9.1...3.10.0
[3.9.1]: https://github.com/guanguans/laravel-soar/compare/3.9.0...3.9.1
[3.9.0]: https://github.com/guanguans/laravel-soar/compare/3.8.3...3.9.0
[3.8.3]: https://github.com/guanguans/laravel-soar/compare/3.8.2...3.8.3
[3.8.2]: https://github.com/guanguans/laravel-soar/compare/3.8.1...3.8.2
[3.8.1]: https://github.com/guanguans/laravel-soar/compare/3.8.0...3.8.1
[3.8.0]: https://github.com/guanguans/laravel-soar/compare/v3.7.1...3.8.0
[v3.7.1]: https://github.com/guanguans/laravel-soar/compare/v3.7.0...v3.7.1
[v3.7.0]: https://github.com/guanguans/laravel-soar/compare/v3.6.1...v3.7.0
[v3.6.1]: https://github.com/guanguans/laravel-soar/compare/v3.6.0...v3.6.1
[v3.6.0]: https://github.com/guanguans/laravel-soar/compare/v3.5.2...v3.6.0
[v3.5.2]: https://github.com/guanguans/laravel-soar/compare/v3.5.1...v3.5.2
[v3.5.1]: https://github.com/guanguans/laravel-soar/compare/v3.5.0...v3.5.1
[v3.5.0]: https://github.com/guanguans/laravel-soar/compare/v3.4.2...v3.5.0
[v3.4.2]: https://github.com/guanguans/laravel-soar/compare/v3.4.1...v3.4.2
[v3.4.1]: https://github.com/guanguans/laravel-soar/compare/v3.4.0...v3.4.1
[v3.4.0]: https://github.com/guanguans/laravel-soar/compare/v3.3.0...v3.4.0
[v3.3.0]: https://github.com/guanguans/laravel-soar/compare/v3.2.0...v3.3.0
[v3.2.0]: https://github.com/guanguans/laravel-soar/compare/v3.1.1...v3.2.0
[v3.1.1]: https://github.com/guanguans/laravel-soar/compare/v3.1.0...v3.1.1
[v3.1.0]: https://github.com/guanguans/laravel-soar/compare/v3.0.2...v3.1.0
[v3.0.2]: https://github.com/guanguans/laravel-soar/compare/v3.0.1...v3.0.2
[v3.0.1]: https://github.com/guanguans/laravel-soar/compare/v3.0.0...v3.0.1
[v3.0.0]: https://github.com/guanguans/laravel-soar/compare/v3.0.0-RC1...v3.0.0
[v3.0.0-RC1]: https://github.com/guanguans/laravel-soar/compare/v3.0.0-BETA1...v3.0.0-RC1
[v3.0.0-BETA1]: https://github.com/guanguans/laravel-soar/compare/v2.3.1...v3.0.0-BETA1
[v2.3.1]: https://github.com/guanguans/laravel-soar/compare/v2.3.0...v2.3.1
[v2.3.0]: https://github.com/guanguans/laravel-soar/compare/v2.2.1...v2.3.0
[v2.2.1]: https://github.com/guanguans/laravel-soar/compare/v2.2.0...v2.2.1
[v2.2.0]: https://github.com/guanguans/laravel-soar/compare/v2.1.3...v2.2.0
[v2.1.3]: https://github.com/guanguans/laravel-soar/compare/v2.1.2...v2.1.3
[v2.1.2]: https://github.com/guanguans/laravel-soar/compare/v2.1.1...v2.1.2
[v2.1.1]: https://github.com/guanguans/laravel-soar/compare/v2.1.0...v2.1.1
[v2.1.0]: https://github.com/guanguans/laravel-soar/compare/v2.0.12...v2.1.0
[v2.0.12]: https://github.com/guanguans/laravel-soar/compare/v2.0.11...v2.0.12
[v2.0.11]: https://github.com/guanguans/laravel-soar/compare/v2.0.10...v2.0.11
[v2.0.10]: https://github.com/guanguans/laravel-soar/compare/v2.0.9...v2.0.10
[v2.0.9]: https://github.com/guanguans/laravel-soar/compare/v2.0.8...v2.0.9
[v2.0.8]: https://github.com/guanguans/laravel-soar/compare/v2.0.7...v2.0.8
[v2.0.7]: https://github.com/guanguans/laravel-soar/compare/v2.0.6...v2.0.7
[v2.0.6]: https://github.com/guanguans/laravel-soar/compare/v2.0.5...v2.0.6
[v2.0.5]: https://github.com/guanguans/laravel-soar/compare/v2.0.4...v2.0.5
[v2.0.4]: https://github.com/guanguans/laravel-soar/compare/v2.0.3...v2.0.4
[v2.0.3]: https://github.com/guanguans/laravel-soar/compare/v2.0.2...v2.0.3
[v2.0.2]: https://github.com/guanguans/laravel-soar/compare/v2.0.1...v2.0.2
[v2.0.1]: https://github.com/guanguans/laravel-soar/compare/v2.0.0...v2.0.1
[v2.0.0]: https://github.com/guanguans/laravel-soar/compare/v1.3.2...v2.0.0
[v1.3.2]: https://github.com/guanguans/laravel-soar/compare/v1.3.1...v1.3.2
[v1.3.1]: https://github.com/guanguans/laravel-soar/compare/v1.3.0...v1.3.1
[v1.3.0]: https://github.com/guanguans/laravel-soar/compare/v1.2.3...v1.3.0
[v1.2.3]: https://github.com/guanguans/laravel-soar/compare/v1.2.2...v1.2.3
[v1.2.2]: https://github.com/guanguans/laravel-soar/compare/v1.2.1...v1.2.2
[v1.2.1]: https://github.com/guanguans/laravel-soar/compare/v1.2.0...v1.2.1
[v1.2.0]: https://github.com/guanguans/laravel-soar/compare/v1.1.2...v1.2.0
[v1.1.2]: https://github.com/guanguans/laravel-soar/compare/v1.1.1...v1.1.2
[v1.1.1]: https://github.com/guanguans/laravel-soar/compare/v1.1.0...v1.1.1
[v1.1.0]: https://github.com/guanguans/laravel-soar/compare/v1.0.3...v1.1.0
[v1.0.3]: https://github.com/guanguans/laravel-soar/compare/v1.0.2...v1.0.3
[v1.0.2]: https://github.com/guanguans/laravel-soar/compare/v1.0.1...v1.0.2
[v1.0.1]: https://github.com/guanguans/laravel-soar/compare/v1.0.0...v1.0.1
