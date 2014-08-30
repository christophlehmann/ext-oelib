<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "oelib".
 *
 * Auto generated 30-08-2014 19:11
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array(
	'title' => 'One is Enough Library',
	'description' => 'This extension provides useful stuff for extension development: helper functions for unit testing, templating, automatic configuration checks and performance benchmarking.',
	'category' => 'services',
	'author' => 'Oliver Klee',
	'author_email' => 'typo3-coding@oliverklee.de',
	'shy' => 0,
	'dependencies' => 'static_info_tables',
	'conflicts' => '',
	'priority' => '',
	'loadOrder' => '',
	'module' => '',
	'state' => 'beta',
	'internal' => '',
	'uploadfolder' => 1,
	'createDirs' => '',
	'modify_tables' => 'be_users,be_groups,fe_groups,fe_users,pages,sys_template,tt_content',
	'clearCacheOnLoad' => 0,
	'lockType' => '',
	'CGLcompliance' => '',
	'CGLcompliance_note' => '',
	'author_company' => 'oliverklee.de',
	'version' => '0.7.79',
	'_md5_values_when_last_written' => 'a:224:{s:13:"changelog.txt";s:4:"142f";s:29:"class.tx_oelib_Autoloader.php";s:4:"4303";s:16:"ext_autoload.php";s:4:"cda4";s:12:"ext_icon.gif";s:4:"b4bf";s:17:"ext_localconf.php";s:4:"6c29";s:14:"ext_tables.php";s:4:"1258";s:14:"ext_tables.sql";s:4:"3b2f";s:11:"LICENSE.txt";s:4:"b234";s:31:"Classes/AbstractHeaderProxy.php";s:4:"3711";s:26:"Classes/AbstractMailer.php";s:4:"c3e8";s:22:"Classes/Attachment.php";s:4:"c27e";s:31:"Classes/BackEndLoginManager.php";s:4:"42e8";s:27:"Classes/CommonConstants.php";s:4:"54df";s:23:"Classes/ConfigCheck.php";s:4:"c86d";s:25:"Classes/Configuration.php";s:4:"708f";s:30:"Classes/ConfigurationProxy.php";s:4:"b2b0";s:33:"Classes/ConfigurationRegistry.php";s:4:"d5e1";s:22:"Classes/DataMapper.php";s:4:"5069";s:14:"Classes/Db.php";s:4:"fad8";s:28:"Classes/Double3Validator.php";s:4:"9077";s:26:"Classes/EmailCollector.php";s:4:"ae31";s:23:"Classes/FakeSession.php";s:4:"08e9";s:25:"Classes/FileFunctions.php";s:4:"33d2";s:32:"Classes/FrontEndLoginManager.php";s:4:"88a8";s:27:"Classes/HeaderCollector.php";s:4:"0798";s:30:"Classes/HeaderProxyFactory.php";s:4:"ebf5";s:23:"Classes/IdentityMap.php";s:4:"dda0";s:16:"Classes/List.php";s:4:"a795";s:16:"Classes/Mail.php";s:4:"238b";s:25:"Classes/MailerFactory.php";s:4:"628e";s:26:"Classes/MapperRegistry.php";s:4:"b03e";s:17:"Classes/Model.php";s:4:"f4dd";s:18:"Classes/Object.php";s:4:"43bb";s:25:"Classes/ObjectFactory.php";s:4:"4574";s:22:"Classes/PageFinder.php";s:4:"0a59";s:24:"Classes/PublicObject.php";s:4:"a9b7";s:27:"Classes/RealHeaderProxy.php";s:4:"93fc";s:22:"Classes/RealMailer.php";s:4:"8a3d";s:30:"Classes/Salutationswitcher.php";s:4:"98d5";s:19:"Classes/Session.php";s:4:"1883";s:20:"Classes/Template.php";s:4:"6202";s:26:"Classes/TemplateHelper.php";s:4:"ee3d";s:28:"Classes/TemplateRegistry.php";s:4:"e0f9";s:28:"Classes/TestingFramework.php";s:4:"ab03";s:35:"Classes/TestingFrameworkCleanup.php";s:4:"943c";s:16:"Classes/Time.php";s:4:"fe9c";s:17:"Classes/Timer.php";s:4:"e7ef";s:22:"Classes/Translator.php";s:4:"7810";s:30:"Classes/TranslatorRegistry.php";s:4:"68c0";s:32:"Classes/Domain/Model/Country.php";s:4:"53ba";s:37:"Classes/Domain/Model/FederalState.php";s:4:"ec69";s:56:"Classes/Domain/Repository/AbstractReadOnlyRepository.php";s:4:"7642";s:47:"Classes/Domain/Repository/CountryRepository.php";s:4:"9d4a";s:52:"Classes/Domain/Repository/FederalStateRepository.php";s:4:"e48d";s:34:"Classes/Exception/AccessDenied.php";s:4:"af9b";s:30:"Classes/Exception/Database.php";s:4:"f767";s:38:"Classes/Exception/EmptyQueryResult.php";s:4:"c6c6";s:30:"Classes/Exception/NotFound.php";s:4:"5810";s:39:"Classes/FrontEnd/UserWithoutCookies.php";s:4:"1095";s:32:"Classes/Geocoding/Calculator.php";s:4:"71cb";s:27:"Classes/Geocoding/Dummy.php";s:4:"1753";s:28:"Classes/Geocoding/Google.php";s:4:"17dd";s:29:"Classes/Interface/Address.php";s:4:"bb38";s:25:"Classes/Interface/Geo.php";s:4:"f1e4";s:37:"Classes/Interface/GeocodingLookup.php";s:4:"8b70";s:30:"Classes/Interface/Identity.php";s:4:"eb35";s:34:"Classes/Interface/LoginManager.php";s:4:"5a4d";s:30:"Classes/Interface/MailRole.php";s:4:"db39";s:30:"Classes/Interface/MapPoint.php";s:4:"1a39";s:30:"Classes/Interface/Sortable.php";s:4:"39bf";s:30:"Classes/Mapper/BackEndUser.php";s:4:"baca";s:35:"Classes/Mapper/BackEndUserGroup.php";s:4:"e137";s:26:"Classes/Mapper/Country.php";s:4:"57bf";s:27:"Classes/Mapper/Currency.php";s:4:"45aa";s:31:"Classes/Mapper/FederalState.php";s:4:"2818";s:31:"Classes/Mapper/FrontEndUser.php";s:4:"8237";s:36:"Classes/Mapper/FrontEndUserGroup.php";s:4:"c212";s:27:"Classes/Mapper/Language.php";s:4:"de3c";s:29:"Classes/Model/BackEndUser.php";s:4:"27f2";s:34:"Classes/Model/BackEndUserGroup.php";s:4:"3bda";s:25:"Classes/Model/Country.php";s:4:"bf12";s:26:"Classes/Model/Currency.php";s:4:"a8f3";s:30:"Classes/Model/FederalState.php";s:4:"4691";s:30:"Classes/Model/FrontEndUser.php";s:4:"82cd";s:35:"Classes/Model/FrontEndUserGroup.php";s:4:"0420";s:26:"Classes/Model/Language.php";s:4:"4d28";s:28:"Classes/ViewHelper/Price.php";s:4:"0e07";s:44:"Classes/ViewHelpers/GoogleMapsViewHelper.php";s:4:"1066";s:45:"Classes/ViewHelpers/ImageSourceViewHelper.php";s:4:"23ac";s:43:"Classes/ViewHelpers/UppercaseViewHelper.php";s:4:"9e1d";s:27:"Classes/Visibility/Node.php";s:4:"ed44";s:27:"Classes/Visibility/Tree.php";s:4:"80ca";s:26:"Configuration/TCA/Test.php";s:4:"be51";s:31:"Configuration/TCA/TestChild.php";s:4:"74fb";s:38:"Configuration/TypoScript/constants.txt";s:4:"d41d";s:34:"Configuration/TypoScript/setup.txt";s:4:"5e3c";s:22:"Packages/composer.json";s:4:"4751";s:22:"Packages/composer.lock";s:4:"527d";s:28:"Packages/vendor/autoload.php";s:4:"f2ee";s:46:"Packages/vendor/composer/autoload_classmap.php";s:4:"8645";s:48:"Packages/vendor/composer/autoload_namespaces.php";s:4:"35e1";s:42:"Packages/vendor/composer/autoload_psr4.php";s:4:"97ed";s:42:"Packages/vendor/composer/autoload_real.php";s:4:"5a66";s:40:"Packages/vendor/composer/ClassLoader.php";s:4:"4796";s:39:"Packages/vendor/composer/installed.json";s:4:"f81f";s:47:"Packages/vendor/pelago/emogrifier/CHANGELOG.TXT";s:4:"7549";s:47:"Packages/vendor/pelago/emogrifier/composer.json";s:4:"5723";s:41:"Packages/vendor/pelago/emogrifier/LICENSE";s:4:"b7aa";s:43:"Packages/vendor/pelago/emogrifier/README.md";s:4:"2061";s:56:"Packages/vendor/pelago/emogrifier/Classes/Emogrifier.php";s:4:"513d";s:95:"Packages/vendor/pelago/emogrifier/Configuration/PhpCodeSniffer/Standards/Emogrifier/ruleset.xml";s:4:"ece6";s:100:"Packages/vendor/pelago/emogrifier/Configuration/PhpCodeSniffer/Standards/EmogrifierTests/ruleset.xml";s:4:"f8ee";s:63:"Packages/vendor/pelago/emogrifier/Tests/Unit/EmogrifierTest.php";s:4:"fe8a";s:40:"Resources/Private/Language/locallang.xml";s:4:"0494";s:43:"Resources/Private/Language/locallang_db.xml";s:4:"a70b";s:31:"Resources/Public/Icons/Test.gif";s:4:"bd58";s:44:"TestExtensions/user_oelibtest/ext_emconf.php";s:4:"c822";s:42:"TestExtensions/user_oelibtest/ext_icon.gif";s:4:"b4bf";s:44:"TestExtensions/user_oelibtest/ext_tables.php";s:4:"c99e";s:44:"TestExtensions/user_oelibtest/ext_tables.sql";s:4:"a0a5";s:58:"TestExtensions/user_oelibtest/icon_user_oelibtest_test.gif";s:4:"475a";s:46:"TestExtensions/user_oelibtest/locallang_db.xml";s:4:"32f9";s:37:"TestExtensions/user_oelibtest/tca.php";s:4:"eccc";s:45:"TestExtensions/user_oelibtest2/ext_emconf.php";s:4:"630b";s:43:"TestExtensions/user_oelibtest2/ext_icon.gif";s:4:"b4bf";s:45:"TestExtensions/user_oelibtest2/ext_tables.php";s:4:"e2a6";s:45:"TestExtensions/user_oelibtest2/ext_tables.sql";s:4:"e709";s:60:"TestExtensions/user_oelibtest2/icon_user_oelibtest2_test.gif";s:4:"475a";s:47:"TestExtensions/user_oelibtest2/locallang_db.xml";s:4:"717d";s:38:"TestExtensions/user_oelibtest2/tca.php";s:4:"28b9";s:33:"Tests/Unit/AbstractMailerTest.php";s:4:"b431";s:29:"Tests/Unit/AttachmentTest.php";s:4:"7fbc";s:29:"Tests/Unit/AutoloaderTest.php";s:4:"91d4";s:38:"Tests/Unit/BackEndLoginManagerTest.php";s:4:"db9c";s:30:"Tests/Unit/ConfigCheckTest.php";s:4:"8cea";s:37:"Tests/Unit/ConfigurationProxyTest.php";s:4:"bd2f";s:40:"Tests/Unit/ConfigurationRegistryTest.php";s:4:"087f";s:32:"Tests/Unit/ConfigurationTest.php";s:4:"05d1";s:29:"Tests/Unit/DataMapperTest.php";s:4:"2e1c";s:21:"Tests/Unit/DbTest.php";s:4:"ca06";s:35:"Tests/Unit/Double3ValidatorTest.php";s:4:"9b0b";s:37:"Tests/Unit/Exception_DatabaseTest.php";s:4:"838b";s:30:"Tests/Unit/FakeSessionTest.php";s:4:"82e1";s:39:"Tests/Unit/FrontEndLoginManagerTest.php";s:4:"fe05";s:37:"Tests/Unit/HeaderProxyFactoryTest.php";s:4:"7b4e";s:30:"Tests/Unit/IdentityMapTest.php";s:4:"a12c";s:23:"Tests/Unit/ListTest.php";s:4:"615f";s:32:"Tests/Unit/MailerFactoryTest.php";s:4:"fbbf";s:23:"Tests/Unit/MailTest.php";s:4:"6ae8";s:33:"Tests/Unit/MapperRegistryTest.php";s:4:"2f9a";s:24:"Tests/Unit/ModelTest.php";s:4:"5bfd";s:32:"Tests/Unit/ObjectFactoryTest.php";s:4:"db9f";s:25:"Tests/Unit/ObjectTest.php";s:4:"60d0";s:29:"Tests/Unit/PageFinderTest.php";s:4:"207c";s:29:"Tests/Unit/PhpMyAdminTest.php";s:4:"58a2";s:29:"Tests/Unit/RealMailerTest.php";s:4:"2d99";s:37:"Tests/Unit/SalutationSwitcherTest.php";s:4:"c5a3";s:26:"Tests/Unit/SessionTest.php";s:4:"f298";s:33:"Tests/Unit/TemplateHelperTest.php";s:4:"88ff";s:35:"Tests/Unit/TemplateRegistryTest.php";s:4:"2615";s:27:"Tests/Unit/TemplateTest.php";s:4:"ddf9";s:35:"Tests/Unit/TestingFrameworkTest.php";s:4:"2a86";s:24:"Tests/Unit/TimerTest.php";s:4:"a682";s:37:"Tests/Unit/TranslatorRegistryTest.php";s:4:"7d9c";s:29:"Tests/Unit/TranslatorTest.php";s:4:"09c0";s:39:"Tests/Unit/Domain/Model/CountryTest.php";s:4:"7f80";s:44:"Tests/Unit/Domain/Model/FederalStateTest.php";s:4:"4835";s:54:"Tests/Unit/Domain/Repository/CountryRepositoryTest.php";s:4:"c9fc";s:59:"Tests/Unit/Domain/Repository/FederalStateRepositoryTest.php";s:4:"719b";s:45:"Tests/Unit/Exception/EmptyQueryResultTest.php";s:4:"30b9";s:70:"Tests/Unit/Fixtures/class.tx_oelib_Tests_Unit_Fixtures_NotIncluded.php";s:4:"b014";s:76:"Tests/Unit/Fixtures/class.Tx_Oelib_Tests_Unit_Fixtures_NotIncludedEither.php";s:4:"9084";s:84:"Tests/Unit/Fixtures/class.Tx_oelib_Tests_Unit_Fixtures_NotIncludedFirstUppercase.php";s:4:"cfca";s:91:"Tests/Unit/Fixtures/class.Tx_Oelib_Tests_Unit_Fixtures_NotIncludedUppercaseExtensionKey.php";s:4:"2abe";s:47:"Tests/Unit/Fixtures/ColumnLessTestingMapper.php";s:4:"a46d";s:42:"Tests/Unit/Fixtures/DummyObjectToCheck.php";s:4:"679e";s:29:"Tests/Unit/Fixtures/Empty.php";s:4:"90ec";s:33:"Tests/Unit/Fixtures/locallang.xml";s:4:"c52b";s:46:"Tests/Unit/Fixtures/ModelLessTestingMapper.php";s:4:"b4c5";s:30:"Tests/Unit/Fixtures/oelib.html";s:4:"59ca";s:37:"Tests/Unit/Fixtures/ReadOnlyModel.php";s:4:"795e";s:46:"Tests/Unit/Fixtures/TableLessTestingMapper.php";s:4:"40a2";s:28:"Tests/Unit/Fixtures/test.css";s:4:"0acf";s:28:"Tests/Unit/Fixtures/test.png";s:4:"c7b6";s:28:"Tests/Unit/Fixtures/test.txt";s:4:"552e";s:30:"Tests/Unit/Fixtures/test_2.css";s:4:"4a4a";s:42:"Tests/Unit/Fixtures/TestingChildMapper.php";s:4:"b759";s:41:"Tests/Unit/Fixtures/TestingChildModel.php";s:4:"3f5d";s:34:"Tests/Unit/Fixtures/TestingGeo.php";s:4:"ca59";s:39:"Tests/Unit/Fixtures/TestingMailRole.php";s:4:"53dc";s:37:"Tests/Unit/Fixtures/TestingMapper.php";s:4:"0692";s:39:"Tests/Unit/Fixtures/TestingMapPoint.php";s:4:"015d";s:36:"Tests/Unit/Fixtures/TestingModel.php";s:4:"2e8d";s:37:"Tests/Unit/Fixtures/TestingObject.php";s:4:"a4cb";s:49:"Tests/Unit/Fixtures/TestingSalutationSwitcher.php";s:4:"d79d";s:45:"Tests/Unit/Fixtures/TestingTemplateHelper.php";s:4:"d4b7";s:36:"Tests/Unit/Fixtures/Xclass/Empty.php";s:4:"79fb";s:79:"Tests/Unit/Fixtures/pi1/class.Tx_Oelib_Tests_Unit_Fixtures_pi1_NotIncluded1.php";s:4:"a09b";s:39:"Tests/Unit/Geocoding/CalculatorTest.php";s:4:"dd22";s:34:"Tests/Unit/Geocoding/DummyTest.php";s:4:"4dde";s:35:"Tests/Unit/Geocoding/GoogleTest.php";s:4:"f07b";s:42:"Tests/Unit/Mapper/BackEndUserGroupTest.php";s:4:"fd43";s:37:"Tests/Unit/Mapper/BackEndUserTest.php";s:4:"5482";s:33:"Tests/Unit/Mapper/CountryTest.php";s:4:"ec71";s:34:"Tests/Unit/Mapper/CurrencyTest.php";s:4:"9591";s:38:"Tests/Unit/Mapper/FederalStateTest.php";s:4:"e9ec";s:43:"Tests/Unit/Mapper/FrontEndUserGroupTest.php";s:4:"2afa";s:38:"Tests/Unit/Mapper/FrontEndUserTest.php";s:4:"1d9d";s:34:"Tests/Unit/Mapper/LanguageTest.php";s:4:"a356";s:41:"Tests/Unit/Model/BackEndUserGroupTest.php";s:4:"26af";s:36:"Tests/Unit/Model/BackEndUserTest.php";s:4:"be48";s:32:"Tests/Unit/Model/CountryTest.php";s:4:"3401";s:33:"Tests/Unit/Model/CurrencyTest.php";s:4:"8f63";s:37:"Tests/Unit/Model/FederalStateTest.php";s:4:"a01c";s:42:"Tests/Unit/Model/FrontEndUserGroupTest.php";s:4:"4238";s:37:"Tests/Unit/Model/FrontEndUserTest.php";s:4:"6bac";s:33:"Tests/Unit/Model/LanguageTest.php";s:4:"5f0b";s:35:"Tests/Unit/ViewHelper/PriceTest.php";s:4:"3521";s:51:"Tests/Unit/ViewHelpers/GoogleMapsViewHelperTest.php";s:4:"1875";s:52:"Tests/Unit/ViewHelpers/ImageSourceViewHelperTest.php";s:4:"1993";s:50:"Tests/Unit/ViewHelpers/UppercaseViewHelperTest.php";s:4:"92a3";s:34:"Tests/Unit/Visibility/NodeTest.php";s:4:"6df1";s:34:"Tests/Unit/Visibility/TreeTest.php";s:4:"4f30";s:14:"doc/manual.sxw";s:4:"9779";}',
	'constraints' => array(
		'depends' => array(
			'php' => '5.3.0-5.5.99',
			'typo3' => '4.5.0-6.2.99',
			'static_info_tables' => '2.0.8-',
		),
		'conflicts' => array(
		),
		'suggests' => array(
			'extbase' => '1.3.0-6.2.99',
		),
	),
	'suggests' => array(
	),
);