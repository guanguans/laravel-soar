<!--- BEGIN HEADER -->
# Changelog

All notable changes to this project will be documented in this file.
<!--- END HEADER -->

<a name="unreleased"></a>
## [Unreleased]


<a name="4.1.2"></a>
## [4.1.2] - 2025-05-23
### 🐞 Bug Fixes
- **config:** update env variable key for excluding queries ([987e101](https://github.com/guanguans/laravel-soar/commit/987e101))

### 💅 Code Refactorings
- **console-commands:** enhance process handling with callback option ([043fdeb](https://github.com/guanguans/laravel-soar/commit/043fdeb))

### 📦 Builds
- **dependencies:** update soar-php and ai-commit versions ([14b2471](https://github.com/guanguans/laravel-soar/commit/14b2471))


<a name="4.1.1"></a>
## [4.1.1] - 2025-05-13
### 🐞 Bug Fixes
- **bootstrapper:** correct empty check logic in query processing ([9932df3](https://github.com/guanguans/laravel-soar/commit/9932df3))
- **output-conditions:** refine content validation in response handling ([0c52dd7](https://github.com/guanguans/laravel-soar/commit/0c52dd7))
- **utils:** correct file path replacement in stack trace ([5463d8a](https://github.com/guanguans/laravel-soar/commit/5463d8a))

### 📖 Documents
- **composer:** update log channels in composer.json documentation ([88e6f33](https://github.com/guanguans/laravel-soar/commit/88e6f33))
- **readme:** add instructions for enabling Soar in Chinese README ([1120a22](https://github.com/guanguans/laravel-soar/commit/1120a22))

### 💅 Code Refactorings
- **Bootstrapper:** streamline score retrieval logic ([03c5bc9](https://github.com/guanguans/laravel-soar/commit/03c5bc9))
- **codebase:** remove unused Soar JSON score methods ([587d2f8](https://github.com/guanguans/laravel-soar/commit/587d2f8))
- **config:** update default value for soar enabled flag ([90ca0b8](https://github.com/guanguans/laravel-soar/commit/90ca0b8))
- **core:** simplify score output handling and streamline dependencies ([27b3837](https://github.com/guanguans/laravel-soar/commit/27b3837))
- **database:** rename soar array score methods for clarity ([b1f8e79](https://github.com/guanguans/laravel-soar/commit/b1f8e79))
- **ide-helper:** remove deprecated SoarHTMLScore methods ([b830a54](https://github.com/guanguans/laravel-soar/commit/b830a54))
- **output-handling:** improve type consistency and utilize collections ([b484aa6](https://github.com/guanguans/laravel-soar/commit/b484aa6))
- **utils:** extend toRawSql method to support additional query types ([55daaa1](https://github.com/guanguans/laravel-soar/commit/55daaa1))

### 🏎 Performance Improvements
- **bootstrapper:** optimize query plucking logic in scoring ([0d4e9be](https://github.com/guanguans/laravel-soar/commit/0d4e9be))
- **output-manager:** optimize output logic and lifecycle events ([351d9ce](https://github.com/guanguans/laravel-soar/commit/351d9ce))

### ✅ Tests
- **QueryBuilderMixin:** add test for quoted raw sql handling in `toRawSql` ([104d49b](https://github.com/guanguans/laravel-soar/commit/104d49b))

### Pull Requests
- Merge pull request [#63](https://github.com/guanguans/laravel-soar/issues/63) from guanguans/dependabot/github_actions/dependabot/fetch-metadata-2.4.0
- Merge pull request [#62](https://github.com/guanguans/laravel-soar/issues/62) from guanguans/imgbot
- Merge pull request [#61](https://github.com/guanguans/laravel-soar/issues/61) from guanguans/imgbot


<a name="4.1.0"></a>
## [4.1.0] - 2025-05-12
### ✨ Features
- **dependency-analyser:** add support for LaraDumps integration ([8e484f8](https://github.com/guanguans/laravel-soar/commit/8e484f8))

### 📖 Documents
- **readme:** add LaraDumps setup guide in Chinese documentation ([941165f](https://github.com/guanguans/laravel-soar/commit/941165f))


<a name="4.0.2"></a>
## [4.0.2] - 2025-05-12
### 📖 Documents
- **README:** update feature list and remove example code ([da6688a](https://github.com/guanguans/laravel-soar/commit/da6688a))

### ✅ Tests
- **helpers:** add environment variable setup in explode env test ([fac9c3b](https://github.com/guanguans/laravel-soar/commit/fac9c3b))

### 📦 Builds
- **dependencies:** update composer dependencies and remove placeholder file ([8eb10b5](https://github.com/guanguans/laravel-soar/commit/8eb10b5))


<a name="4.0.1"></a>
## [4.0.1] - 2025-05-11
### 🐞 Bug Fixes
- **issue-template:** update URLs to use 'master' instead of 'main' ([71f3c77](https://github.com/guanguans/laravel-soar/commit/71f3c77))
- **output:** enhance output handling and score sanitization ([c9a2d90](https://github.com/guanguans/laravel-soar/commit/c9a2d90))
- **query-builder:** improve SQL query binding for toRawSql ([7c2506d](https://github.com/guanguans/laravel-soar/commit/7c2506d))
- **scores:** improve scores sorting and remove duplicate methods ([d95e952](https://github.com/guanguans/laravel-soar/commit/d95e952))
- **utils:** update backtraces method to support list of lines ([c98127a](https://github.com/guanguans/laravel-soar/commit/c98127a))

### 💅 Code Refactorings
- **bootstrapper:** replace inline listener logic with dedicated class ([5bab9e7](https://github.com/guanguans/laravel-soar/commit/5bab9e7))
- **query-builder-mixin:** improve chainability of diagnostic methods ([713d19e](https://github.com/guanguans/laravel-soar/commit/713d19e))
- **utils:** centralize star generation logic in a utility class ([500628d](https://github.com/guanguans/laravel-soar/commit/500628d))

### 🏎 Performance Improvements
- **SoarServiceProvider:** optimize application boot process ([72474b3](https://github.com/guanguans/laravel-soar/commit/72474b3))

### ✅ Tests
- **project:** enhance testing and configuration setups ([ba68e32](https://github.com/guanguans/laravel-soar/commit/ba68e32))
- **utils:** refactor and enhance utility functions with improved structure ([3116864](https://github.com/guanguans/laravel-soar/commit/3116864))
- **workbench:** integrate workbench structure and refactor tests ([8b7d200](https://github.com/guanguans/laravel-soar/commit/8b7d200))


<a name="4.0.0"></a>
## [4.0.0] - 2025-05-08
### ✨ Features
- **commands:** add Soar binary download command ([7880f14](https://github.com/guanguans/laravel-soar/commit/7880f14))
- **composer:** Update PHP and package requirements ([5449859](https://github.com/guanguans/laravel-soar/commit/5449859))

### 🐞 Bug Fixes
- **dependencies:** update guanguans/soar-php to ^6.1 and refactor related usages ([9effcc8](https://github.com/guanguans/laravel-soar/commit/9effcc8))
- **query-builder-mixin:** specify return type for closure functions ([dfe2d01](https://github.com/guanguans/laravel-soar/commit/dfe2d01))

### 🎨 Styles
- apply php-cs-fixer ([a2eba03](https://github.com/guanguans/laravel-soar/commit/a2eba03))
- apply php-cs-fixer ([f14c991](https://github.com/guanguans/laravel-soar/commit/f14c991))

### 💅 Code Refactorings
- apply rector ([3a101ab](https://github.com/guanguans/laravel-soar/commit/3a101ab))
- apply inspection ([178a481](https://github.com/guanguans/laravel-soar/commit/178a481))
- **bootstrapper:** simplify query logging and output monitoring setup ([706abee](https://github.com/guanguans/laravel-soar/commit/706abee))
- **commands:** enhance log clearing messages and test structure ([ea48b52](https://github.com/guanguans/laravel-soar/commit/ea48b52))
- **commands:** update soar option handling and improve user prompts ([f69bb2d](https://github.com/guanguans/laravel-soar/commit/f69bb2d))
- **commands:** remove download command and its test ([02c1294](https://github.com/guanguans/laravel-soar/commit/02c1294))
- **config:** rename soar exclusions key for consistency ([e591971](https://github.com/guanguans/laravel-soar/commit/e591971))
- **config:** update soar configuration keys and comments ([31740b9](https://github.com/guanguans/laravel-soar/commit/31740b9))
- **contracts:** rename Output interface to OutputContract ([4031015](https://github.com/guanguans/laravel-soar/commit/4031015))
- **contracts:** rename interfaces for consistency ([c499223](https://github.com/guanguans/laravel-soar/commit/c499223))
- **debug:** remove unused helper and commented logic in DebugBarOutput ([b527ae0](https://github.com/guanguans/laravel-soar/commit/b527ae0))
- **events:** enhance OutputtedEvent to include outputter ([e819b6b](https://github.com/guanguans/laravel-soar/commit/e819b6b))
- **helpers:** replace utility functions with improved implementation ([79ad66e](https://github.com/guanguans/laravel-soar/commit/79ad66e))
- **middleware:** rename OutputSoarScoresMiddleware to OutputScoresMiddleware ([37f3c3f](https://github.com/guanguans/laravel-soar/commit/37f3c3f))
- **namespace:** simplify middleware namespace structure ([2cbe763](https://github.com/guanguans/laravel-soar/commit/2cbe763))
- **namespace:** update `Macros` to `Mixins` in QueryBuilderMacro ([be51659](https://github.com/guanguans/laravel-soar/commit/be51659))
- **output:** replace variable name 'dispatcher' with 'outputter' ([c0fec88](https://github.com/guanguans/laravel-soar/commit/c0fec88))
- **outputs:** rename base Output class and update usage ([c4fdb29](https://github.com/guanguans/laravel-soar/commit/c4fdb29))
- **outputs:** remove NullOutput class and its usage ([447691a](https://github.com/guanguans/laravel-soar/commit/447691a))
- **outputs:** Remove SoarBarOutput and SoarBar classes ([0e6a946](https://github.com/guanguans/laravel-soar/commit/0e6a946))
- **outputs:** remove unused output handlers and update documentation ([60fbf22](https://github.com/guanguans/laravel-soar/commit/60fbf22))
- **outputs:** update visibility modifier for constructor properties ([8335c56](https://github.com/guanguans/laravel-soar/commit/8335c56))
- **tests:** improve tests structure and update method definitions ([4ab0889](https://github.com/guanguans/laravel-soar/commit/4ab0889))

### ✅ Tests
- **namespace:** streamline namespace usage in tests ([9e5bfd1](https://github.com/guanguans/laravel-soar/commit/9e5bfd1))
- **unit:** improve test utilities and setup ([0c8895f](https://github.com/guanguans/laravel-soar/commit/0c8895f))

### 📦 Builds
- **composer:** Update Laravel framework and add new dependencies ([6314d23](https://github.com/guanguans/laravel-soar/commit/6314d23))
- **config:** enhance project configuration and streamline file management ([108c3d4](https://github.com/guanguans/laravel-soar/commit/108c3d4))
- **dependencies:** update composer dependencies ([8f67a94](https://github.com/guanguans/laravel-soar/commit/8f67a94))

### 🤖 Continuous Integrations
- apply phpstan level max ([c5c024c](https://github.com/guanguans/laravel-soar/commit/c5c024c))
- apply phpstan level 7 ([2a9c8af](https://github.com/guanguans/laravel-soar/commit/2a9c8af))
- apply phpstan level 6 ([96d0fda](https://github.com/guanguans/laravel-soar/commit/96d0fda))
- apply phpstan level 5 ([a584b32](https://github.com/guanguans/laravel-soar/commit/a584b32))
- **config:** enhance PHPStan configuration and improve QueryBuilderMixin docblock ([87a7118](https://github.com/guanguans/laravel-soar/commit/87a7118))
- **config:** update linting and analysis configurations ([00e396a](https://github.com/guanguans/laravel-soar/commit/00e396a))
- **dependencies:** add phpstan-strict-rules to composer dependencies ([a59ac46](https://github.com/guanguans/laravel-soar/commit/a59ac46))
- **phpstan:** update phpstan configuration to apply revised parameters ([1327e73](https://github.com/guanguans/laravel-soar/commit/1327e73))
- **setup:** enhance configuration and update file handling rules ([4831910](https://github.com/guanguans/laravel-soar/commit/4831910))
- **templates:** migrate issue templates to YAML and improve workflows ([cadf102](https://github.com/guanguans/laravel-soar/commit/cadf102))
- **workflow:** update php-cs-fixer workflow steps ([e100697](https://github.com/guanguans/laravel-soar/commit/e100697))
- **workflows:** adjust dependency installation order in test workflow ([aadf633](https://github.com/guanguans/laravel-soar/commit/aadf633))


<a name="3.18.1"></a>
## [3.18.1] - 2025-05-03
### 📦 Builds
- **changelog:** Enhance changelog template and configuration ([773a6d6](https://github.com/guanguans/laravel-soar/commit/773a6d6))
- **dependencies:** update package versions in composer.json ([bf66705](https://github.com/guanguans/laravel-soar/commit/bf66705))

### 🤖 Continuous Integrations
- **rector:** Add composer-updater path to configuration ([a8079db](https://github.com/guanguans/laravel-soar/commit/a8079db))


<a name="3.18.0"></a>
## [3.18.0] - 2025-03-01
### ✨ Features
- **dependencies:** Update Composer package versions and options ([46f1c87](https://github.com/guanguans/laravel-soar/commit/46f1c87))

### 🤖 Continuous Integrations
- **config:** Remove friendly error formatting in PHPStan config ([91e00de](https://github.com/guanguans/laravel-soar/commit/91e00de))
- **dependencies:** Add PHPStan extensions and update composer.json ([c03ac94](https://github.com/guanguans/laravel-soar/commit/c03ac94))
- **workflows:** Update PHP and Laravel versions in tests.yml ([016f38f](https://github.com/guanguans/laravel-soar/commit/016f38f))

### Pull Requests
- Merge pull request [#59](https://github.com/guanguans/laravel-soar/issues/59) from guanguans/dependabot/github_actions/dependabot/fetch-metadata-2.3.0


<a name="3.17.0"></a>
## [3.17.0] - 2025-01-17
### ✨ Features
- **ScoreCommand:** Read SQL from standard input if available ([7ff2882](https://github.com/guanguans/laravel-soar/commit/7ff2882))

### 📖 Documents
- **README:** Update badge links in the README file ([f4d05d3](https://github.com/guanguans/laravel-soar/commit/f4d05d3))

### 📦 Builds
- **composer:** Update dependencies and improve command handling ([3745e32](https://github.com/guanguans/laravel-soar/commit/3745e32))

### 🤖 Continuous Integrations
- **config:** Update PHPStan and Psalm configurations ([8fd5c62](https://github.com/guanguans/laravel-soar/commit/8fd5c62))

### Pull Requests
- Merge pull request [#58](https://github.com/guanguans/laravel-soar/issues/58) from guanguans/dependabot/composer/guanguans/soar-php-tw-5.0


<a name="3.16.3"></a>
## [3.16.3] - 2024-08-16
### ✨ Features
- **dependencies:** update development dependencies versions ([993c8cd](https://github.com/guanguans/laravel-soar/commit/993c8cd))

### 🏎 Performance Improvements
- **bootstrapper:** Optimize sprintf usage ([1e88f7e](https://github.com/guanguans/laravel-soar/commit/1e88f7e))

### 🤖 Continuous Integrations
- **rector:** add new rules for Rector configuration ([592a0c4](https://github.com/guanguans/laravel-soar/commit/592a0c4))

### Pull Requests
- Merge pull request [#56](https://github.com/guanguans/laravel-soar/issues/56) from guanguans/dependabot/github_actions/dependabot/fetch-metadata-2.2.0


<a name="3.16.2"></a>
## [3.16.2] - 2024-06-17
### 🐞 Bug Fixes
- **OutputConditions:** Improve content checking in isHtmlResponse and isJsonResponse ([9a3b0f8](https://github.com/guanguans/laravel-soar/commit/9a3b0f8))

### 🎨 Styles
- **composer.json:** update dependencies versions ([e307489](https://github.com/guanguans/laravel-soar/commit/e307489))

### Pull Requests
- Merge pull request [#54](https://github.com/guanguans/laravel-soar/issues/54) from guanguans/imgbot


<a name="3.16.1"></a>
## [3.16.1] - 2024-06-11
### ✨ Features
- **commands.tape:** add new commands and update existing commands ([d3bf474](https://github.com/guanguans/laravel-soar/commit/d3bf474))
- **commands.tape:** add commands tape for recording commands ([ab63c1c](https://github.com/guanguans/laravel-soar/commit/ab63c1c))

### 📖 Documents
- **readme:** update available commands section ([f097dc5](https://github.com/guanguans/laravel-soar/commit/f097dc5))

### 💅 Code Refactorings
- **commands:** Update output method in WithSoarOptions trait ([12e7439](https://github.com/guanguans/laravel-soar/commit/12e7439))

### ✅ Tests
- Add RunCommandTest and update ScoreCommandTest ([aadba22](https://github.com/guanguans/laravel-soar/commit/aadba22))


<a name="3.16.0"></a>
## [3.16.0] - 2024-06-07
### ✨ Features
- **commands:** Add RunCommand ([f062a45](https://github.com/guanguans/laravel-soar/commit/f062a45))

### 💅 Code Refactorings
- **commands:** Refactor ScoreCommand handle method ([a354fc2](https://github.com/guanguans/laravel-soar/commit/a354fc2))
- **score:** Improve Soar score command signature and options handling ([0339e22](https://github.com/guanguans/laravel-soar/commit/0339e22))


<a name="3.15.1"></a>
## [3.15.1] - 2024-06-07
### 💅 Code Refactorings
- **commands:** improve input handling in ScoreCommand ([08e6ef0](https://github.com/guanguans/laravel-soar/commit/08e6ef0))


<a name="3.15.0"></a>
## [3.15.0] - 2024-06-06
### ✨ Features
- **commands:** Add ScoreCommand class ([1648268](https://github.com/guanguans/laravel-soar/commit/1648268))
- **config:** Add parallel config for PHP-CS-Fixer ([bd32330](https://github.com/guanguans/laravel-soar/commit/bd32330))

### ✅ Tests
- **commands:** add test for ScoreCommand ([2a8a473](https://github.com/guanguans/laravel-soar/commit/2a8a473))


<a name="3.14.2"></a>
## [3.14.2] - 2024-06-06
### Pull Requests
- Merge pull request [#53](https://github.com/guanguans/laravel-soar/issues/53) from guanguans/dependabot/github_actions/dependabot/fetch-metadata-2.1.0


<a name="3.14.1"></a>
## [3.14.1] - 2024-04-01
### ✨ Features
- **Soar.php:** Implement dynamic method calls and remove Conditionable trait ([923b332](https://github.com/guanguans/laravel-soar/commit/923b332))

### 🤖 Continuous Integrations
- Added SoarTest.php to test LaravelSoar facade ([b209007](https://github.com/guanguans/laravel-soar/commit/b209007))


<a name="3.14.0"></a>
## [3.14.0] - 2024-04-01

<a name="3.13.0"></a>
## [3.13.0] - 2024-04-01
### 📖 Documents
- **readme:** Update README files with code snippet ([b7d0863](https://github.com/guanguans/laravel-soar/commit/b7d0863))

### 💅 Code Refactorings
- **core:** Remove redundant code and update middleware registration ([45d0670](https://github.com/guanguans/laravel-soar/commit/45d0670))


<a name="3.12.1"></a>
## [3.12.1] - 2024-04-01
### 💅 Code Refactorings
- **README:** update code comments ([f3ffb4a](https://github.com/guanguans/laravel-soar/commit/f3ffb4a))

### 🤖 Continuous Integrations
- **tests:** Add Clover.xml file for Codecov upload ([4e9991a](https://github.com/guanguans/laravel-soar/commit/4e9991a))

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
### 🐞 Bug Fixes
- **composer-fixer:** remove dry-run option from normalize command ([df1d4cd](https://github.com/guanguans/laravel-soar/commit/df1d4cd))

### 💅 Code Refactorings
- Update Soar binary path in code and config ([28cd265](https://github.com/guanguans/laravel-soar/commit/28cd265))
- **config:** Update SoarServiceProvider.php ([23763cb](https://github.com/guanguans/laravel-soar/commit/23763cb))

### Pull Requests
- Merge pull request [#47](https://github.com/guanguans/laravel-soar/issues/47) from guanguans/dependabot/composer/guanguans/soar-php-tw-4.0
- Merge pull request [#46](https://github.com/guanguans/laravel-soar/issues/46) from guanguans/dependabot/composer/rector/rector-tw-0.19


<a name="3.10.1"></a>
## [3.10.1] - 2024-01-07
### ✅ Tests
- **Feature:** add test for outputting console ([c30e1eb](https://github.com/guanguans/laravel-soar/commit/c30e1eb))


<a name="3.10.0"></a>
## [3.10.0] - 2024-01-07
### 💅 Code Refactorings
- **config:** exclude telescope commands and URLs from soar scoring ([6e87fbf](https://github.com/guanguans/laravel-soar/commit/6e87fbf))
- **output:** implement shouldOutput method ([247dfb0](https://github.com/guanguans/laravel-soar/commit/247dfb0))


<a name="3.9.1"></a>
## [3.9.1] - 2024-01-04
### 📖 Documents
- **README:** update check & fix styling badge link ([c39ea45](https://github.com/guanguans/laravel-soar/commit/c39ea45))

### 💅 Code Refactorings
- **monorepo-builder:** update release workers ([4777a8e](https://github.com/guanguans/laravel-soar/commit/4777a8e))

### Pull Requests
- Merge pull request [#45](https://github.com/guanguans/laravel-soar/issues/45) from guanguans/dependabot/github_actions/actions/stale-9
- Merge pull request [#44](https://github.com/guanguans/laravel-soar/issues/44) from guanguans/dependabot/github_actions/actions/labeler-5


<a name="3.9.0"></a>
## [3.9.0] - 2023-10-18
### 🐞 Bug Fixes
- **.php-cs-fixer:** update curly_braces_position ([ce02d1f](https://github.com/guanguans/laravel-soar/commit/ce02d1f))

### 💅 Code Refactorings
- **Bootstrapper:** improve toSql method ([2a04eea](https://github.com/guanguans/laravel-soar/commit/2a04eea))

### Pull Requests
- Merge pull request [#43](https://github.com/guanguans/laravel-soar/issues/43) from guanguans/dependabot/github_actions/stefanzweifel/git-auto-commit-action-5
- Merge pull request [#42](https://github.com/guanguans/laravel-soar/issues/42) from guanguans/dependabot/github_actions/codecov/codecov-action-4
- Merge pull request [#41](https://github.com/guanguans/laravel-soar/issues/41) from guanguans/dependabot/github_actions/actions/checkout-4


<a name="3.8.3"></a>
## [3.8.3] - 2023-08-30
### ✨ Features
- **facade:** Add facade.php file ([e9c7bc1](https://github.com/guanguans/laravel-soar/commit/e9c7bc1))

### 🐞 Bug Fixes
- **QueryAnalyzer:** Fix anonymous function parameter type ([972e051](https://github.com/guanguans/laravel-soar/commit/972e051))

### 📖 Documents
- Update README.md with Chinese translation link ([84e70d1](https://github.com/guanguans/laravel-soar/commit/84e70d1))

### 💅 Code Refactorings
- **tests:** update OutputTest.php ([c88ab7e](https://github.com/guanguans/laravel-soar/commit/c88ab7e))

### ✅ Tests
- **OutputTest:** Update console output functionality ([e3b744c](https://github.com/guanguans/laravel-soar/commit/e3b744c))
- **TestCase.php:** Add Mockery integration ([20dd278](https://github.com/guanguans/laravel-soar/commit/20dd278))

### Pull Requests
- Merge pull request [#40](https://github.com/guanguans/laravel-soar/issues/40) from guanguans/dependabot/composer/rector/rector-tw-0.18


<a name="3.8.2"></a>
## [3.8.2] - 2023-07-27
### 🐞 Bug Fixes
- **Bootstrapper:** return correct SQL string ([856822f](https://github.com/guanguans/laravel-soar/commit/856822f))

### 📖 Documents
- **composer:** Update composer.json suggestions ([f649ce9](https://github.com/guanguans/laravel-soar/commit/f649ce9))


<a name="3.8.1"></a>
## [3.8.1] - 2023-07-24
### 🐞 Bug Fixes
- **AssetController:** Fix font file path ([3fa3518](https://github.com/guanguans/laravel-soar/commit/3fa3518))


<a name="3.8.0"></a>
## [3.8.0] - 2023-07-23
### ✨ Features
- **composer.json:** add monorepo-builder-worker package ([d7b82ff](https://github.com/guanguans/laravel-soar/commit/d7b82ff))

### 💅 Code Refactorings
- **tests:** Update function names in QueryBuilderMacroTest ([16b0fd5](https://github.com/guanguans/laravel-soar/commit/16b0fd5))


<a name="v3.7.1"></a>
## [v3.7.1] - 2023-07-16
### 🐞 Bug Fixes
- **routes:** Update route namespace in web.php ([11e8bd2](https://github.com/guanguans/laravel-soar/commit/11e8bd2))


<a name="v3.7.0"></a>
## [v3.7.0] - 2023-07-16
### ✨ Features
- **commands:** add ClearCommand ([8b772d7](https://github.com/guanguans/laravel-soar/commit/8b772d7))

### 💅 Code Refactorings
- **rector.php:** Remove unused rules ([90f55dd](https://github.com/guanguans/laravel-soar/commit/90f55dd))

### ✅ Tests
- **commands:** Add ClearCommandTest ([f602e62](https://github.com/guanguans/laravel-soar/commit/f602e62))


<a name="v3.6.1"></a>
## [v3.6.1] - 2023-07-14
### ✨ Features
- **composer.json:** Add facades-lint and facades-update commands ([c904b29](https://github.com/guanguans/laravel-soar/commit/c904b29))

### 💅 Code Refactorings
- **JsonOutput:** update data assignment ([78e96bc](https://github.com/guanguans/laravel-soar/commit/78e96bc))
- **ServiceProvider:** Improve SoarServiceProvider ([90d8390](https://github.com/guanguans/laravel-soar/commit/90d8390))


<a name="v3.6.0"></a>
## [v3.6.0] - 2023-07-14

<a name="v3.5.2"></a>
## [v3.5.2] - 2023-06-30
### ✨ Features
- **composer.json:** Add new dependencies ([67fd2f7](https://github.com/guanguans/laravel-soar/commit/67fd2f7))

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
### 🎨 Styles
- Fix style ([bbdaf9d](https://github.com/guanguans/laravel-soar/commit/bbdaf9d))

### Pull Requests
- Merge pull request [#8](https://github.com/guanguans/laravel-soar/issues/8) from guanguans/imgbot


<a name="v1.0.3"></a>
## [v1.0.3] - 2021-04-29
### 📖 Documents
- Add comment docs for facade ([10a65cc](https://github.com/guanguans/laravel-soar/commit/10a65cc))

### 🤖 Continuous Integrations
- Add some CI config files ([24f6fd0](https://github.com/guanguans/laravel-soar/commit/24f6fd0))


<a name="v1.0.2"></a>
## [v1.0.2] - 2021-04-25
### 📖 Documents
- Update README.md ([e631ac0](https://github.com/guanguans/laravel-soar/commit/e631ac0))

### 🎨 Styles
- Fix style ([b3710a1](https://github.com/guanguans/laravel-soar/commit/b3710a1))

### 🤖 Continuous Integrations
- Update some CI config files ([b2ad5c6](https://github.com/guanguans/laravel-soar/commit/b2ad5c6))


<a name="v1.0.1"></a>
## [v1.0.1] - 2020-10-19

<a name="v1.0.0"></a>
## v1.0.0 - 2020-06-27
### Pull Requests
- Merge pull request [#1](https://github.com/guanguans/laravel-soar/issues/1) from guanguans/add-license-1


[Unreleased]: https://github.com/guanguans/laravel-soar/compare/4.1.2...HEAD
[4.1.2]: https://github.com/guanguans/laravel-soar/compare/4.1.1...4.1.2
[4.1.1]: https://github.com/guanguans/laravel-soar/compare/4.1.0...4.1.1
[4.1.0]: https://github.com/guanguans/laravel-soar/compare/4.0.2...4.1.0
[4.0.2]: https://github.com/guanguans/laravel-soar/compare/4.0.1...4.0.2
[4.0.1]: https://github.com/guanguans/laravel-soar/compare/4.0.0...4.0.1
[4.0.0]: https://github.com/guanguans/laravel-soar/compare/3.18.1...4.0.0
[3.18.1]: https://github.com/guanguans/laravel-soar/compare/3.18.0...3.18.1
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
