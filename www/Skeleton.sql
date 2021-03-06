﻿CREATE TABLE UserTitles (
	TitleName VARCHAR(32) NOT NULL UNIQUE,
	TitleDescription VARCHAR(64) NOT NULL,
	PRIMARY KEY (TitleName)
);

CREATE TABLE User (
	UserEmail VARCHAR(32) NOT NULL UNIQUE,
	UserName VARCHAR(32) NOT NULL,
	UserSurname VARCHAR(32) NOT NULL,
	UserPhone VARCHAR(14) NOT NULL UNIQUE,
	UserPassword VARCHAR(32) NOT NULL,
	TitleName VARCHAR(32) NOT NULL,
	UserEnable BOOLEAN DEFAULT TRUE,
	PRIMARY KEY (UserEmail),
	FOREIGN KEY (TitleName) REFERENCES UserTitles (TitleName) ON DELETE CASCADE ON UPDATE CASCADE 
);

CREATE TABLE Pages (
	PageName VARCHAR(32) NOT NULL UNIQUE,
	PageURL VARCHAR(64) NOT NULL,
	PageEnable BOOLEAN DEFAULT TRUE,
	PageDescription VARCHAR(64) NOT NULL,
	PRIMARY KEY (PageName)
);

CREATE TABLE UserRoleTypes (
	RoleName VARCHAR(32) NOT NULL UNIQUE,
	PageName VARCHAR(32),
	RoleDescription VARCHAR(64) NOT NULL,
	PRIMARY KEY (RoleName),
	FOREIGN KEY (PageName) REFERENCES Pages (PageName) ON DELETE CASCADE ON UPDATE CASCADE 
);

CREATE TABLE UserTitleRoles (
	TitleRoleID INT NOT NULL UNIQUE AUTO_INCREMENT,
	TitleName VARCHAR(32) NOT NULL,
	RoleName VARCHAR(32) NOT NULL,
	FOREIGN KEY (TitleName) REFERENCES UserTitles (TitleName) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (RoleName) REFERENCES UserRoleTypes (RoleName) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE MainMenu (
	MainMenuID INT UNIQUE NOT NULL AUTO_INCREMENT,
	PageName VARCHAR(32),
	MainMenuText VARCHAR(64) DEFAULT '',
	MainMenuParent INT DEFAULT 0,
	PRIMARY KEY (MainMenuID),
	FOREIGN KEY (PageName) REFERENCES Pages (PageName) ON DELETE CASCADE ON UPDATE CASCADE
);

INSERT INTO Pages (PageName, PageURL, PageDescription) VALUES ('PAGE_MAIN', 'main.php', 'AnaSayfa');
INSERT INTO Pages (PageName, PageURL, PageDescription) VALUES ('PAGE_USER_PASSWORD_RESET', 'ChangePassword.php', 'Parola değiştir');
INSERT INTO Pages (PageName, PageURL, PageDescription) VALUES ('PAGE_USER_PROFILE', 'profile.php', 'Profil görüntüle');

INSERT INTO Pages (PageName, PageURL, PageDescription) VALUES ('PAGE_HRM_USER_ADD', 'Add/User.php', 'Kullanıcı oluştur');
INSERT INTO Pages (PageName, PageURL, PageDescription) VALUES ('PAGE_HRM_USER_SEARCH', 'Search/User.php', 'Kullanıcı bul');
INSERT INTO Pages (PageName, PageURL, PageDescription) VALUES ('PAGE_HRM_USER_UPDATE', 'Update/User.php', 'Kullanıcıyı güncelle');
INSERT INTO Pages (PageName, PageURL, PageDescription) VALUES ('PAGE_HRM_USER_REMOVE', 'Remove/User.php', 'Kullanıcıyı sil');
INSERT INTO Pages (PageName, PageURL, PageDescription) VALUES ('PAGE_HRM_USER_PASSWORD_RESET', 'ChangePassword.php', 'Parola sıfırla');

INSERT INTO Pages (PageName, PageURL, PageDescription) VALUES ('PAGE_DEV_PAGE_ADD', 'Add/Page.php', 'Sayfa oluştur');
INSERT INTO Pages (PageName, PageURL, PageDescription) VALUES ('PAGE_DEV_PAGE_SEARCH', 'Search/Page.php', 'Sayfa bul');
INSERT INTO Pages (PageName, PageURL, PageDescription) VALUES ('PAGE_DEV_PAGE_UPDATE', 'Update/Page.php', 'Sayfayı güncelle');
INSERT INTO Pages (PageName, PageURL, PageDescription) VALUES ('PAGE_DEV_PAGE_REMOVE', 'Remove/Page.php', 'Sayfayı sil');

INSERT INTO Pages (PageName, PageURL, PageDescription) VALUES ('PAGE_DEV_SQL_SELECT', 'SQLSelect.php', 'SQL veri çekme');
INSERT INTO Pages (PageName, PageURL, PageDescription) VALUES ('PAGE_DEV_SQL_EXECUTE', 'SQLExecute.php', 'SQL script çalıştırma');

INSERT INTO Pages (PageName, PageURL, PageDescription) VALUES ('PAGE_HRM_USER_TITLES_ADD', 'Add/UserTitle.php', 'Kullanıcı ünvanı oluştur');
INSERT INTO Pages (PageName, PageURL, PageDescription) VALUES ('PAGE_HRM_USER_TITLES_SEARCH', 'Search/UserTitle.php', 'Kullanıcı ünvanı bul');
INSERT INTO Pages (PageName, PageURL, PageDescription) VALUES ('PAGE_HRM_USER_TITLES_UPDATE', 'Update/UserTitle.php', 'Kullanıcı ünvanını güncelle');
INSERT INTO Pages (PageName, PageURL, PageDescription) VALUES ('PAGE_HRM_USER_TITLES_REMOVE', 'Remove/UserTitle.php', 'Kullanıcı ünvanını sil');

INSERT INTO Pages (PageName, PageURL, PageDescription) VALUES ('PAGE_DEV_ROLE_TYPES_ADD', 'Add/RoleType.php', 'Kullanıcı rolü oluştur');
INSERT INTO Pages (PageName, PageURL, PageDescription) VALUES ('PAGE_DEV_ROLE_TYPES_SEARCH', 'Search/RoleType.php', 'Kullanıcı rolü bul');
INSERT INTO Pages (PageName, PageURL, PageDescription) VALUES ('PAGE_DEV_ROLE_TYPES_UPDATE', 'Update/RoleType.php', 'Kullanıcı rolünü güncelle');
INSERT INTO Pages (PageName, PageURL, PageDescription) VALUES ('PAGE_DEV_ROLE_TYPES_REMOVE', 'Remove/RoleType.php', 'Kullanıcı rolünü sil');

INSERT INTO Pages (PageName, PageURL, PageDescription) VALUES ('PAGE_DEV_MAINMENU_ADD', 'Add/MainMenu.php', 'Ana menü oluştur');
INSERT INTO Pages (PageName, PageURL, PageDescription) VALUES ('PAGE_DEV_MAINMENU_SEARCH', 'Search/MainMenu.php', 'Ana menü bul');
INSERT INTO Pages (PageName, PageURL, PageDescription) VALUES ('PAGE_DEV_MAINMENU_UPDATE', 'Update/MainMenu.php', 'Ana menüyü güncelle');
INSERT INTO Pages (PageName, PageURL, PageDescription) VALUES ('PAGE_DEV_MAINMENU_REMOVE', 'Remove/MainMenu.php', 'Ana menüyü sil');

INSERT INTO Pages (PageName, PageURL, PageDescription) VALUES ('PAGE_HRM_TITLE_ROLES_ADD', 'Add/TitleRoles.php', 'Ünvan rolü oluştur');
INSERT INTO Pages (PageName, PageURL, PageDescription) VALUES ('PAGE_HRM_TITLE_ROLES_SEARCH', 'Search/TitleRoles.php', 'Ünvan rolü bul');
INSERT INTO Pages (PageName, PageURL, PageDescription) VALUES ('PAGE_HRM_TITLE_ROLES_UPDATE', 'Update/TitleRoles.php', 'Ünvan rolünü güncelle');
INSERT INTO Pages (PageName, PageURL, PageDescription) VALUES ('PAGE_HRM_TITLE_ROLES_REMOVE', 'Remove/TitleRoles.php', 'Ünvan rolünü sil');	

INSERT INTO MainMenu(PageName) VALUES ('PAGE_MAIN');
INSERT INTO MainMenu(MainMenuText) VALUES ('Ekle');
INSERT INTO MainMenu(MainMenuText) VALUES ('Bul');
INSERT INTO MainMenu(MainMenuText) VALUES ('Kullanıcı işlemleri');
INSERT INTO MainMenu(MainMenuText) VALUES ('Muhasebe');
INSERT INTO MainMenu(MainMenuText) VALUES ('Geliştirici');
INSERT INTO MainMenu(PageName, MainMenuParent) VALUES ('PAGE_USER_PROFILE', 4);
INSERT INTO MainMenu(PageName, MainMenuParent) VALUES ('PAGE_USER_PASSWORD_RESET', 4);
INSERT INTO MainMenu(PageName, MainMenuParent) VALUES ('PAGE_HRM_USER_ADD', 4);
INSERT INTO MainMenu(PageName, MainMenuParent) VALUES ('PAGE_HRM_USER_SEARCH', 4);
INSERT INTO MainMenu(PageName, MainMenuParent) VALUES ('PAGE_HRM_USER_TITLES_ADD', 4);
INSERT INTO MainMenu(PageName, MainMenuParent) VALUES ('PAGE_HRM_USER_TITLES_SEARCH', 4);
INSERT INTO MainMenu(PageName, MainMenuParent) VALUES ('PAGE_HRM_TITLE_ROLES_ADD', 4);
INSERT INTO MainMenu(PageName, MainMenuParent) VALUES ('PAGE_HRM_TITLE_ROLES_SEARCH', 4);
INSERT INTO MainMenu(PageName, MainMenuParent) VALUES ('PAGE_DEV_SQL_SELECT', 6);
INSERT INTO MainMenu(PageName, MainMenuParent) VALUES ('PAGE_DEV_SQL_EXECUTE', 6);
INSERT INTO MainMenu(PageName, MainMenuParent) VALUES ('PAGE_DEV_PAGE_ADD', 6);
INSERT INTO MainMenu(PageName, MainMenuParent) VALUES ('PAGE_DEV_PAGE_SEARCH', 6);
INSERT INTO MainMenu(PageName, MainMenuParent) VALUES ('PAGE_DEV_ROLE_TYPES_ADD', 6);
INSERT INTO MainMenu(PageName, MainMenuParent) VALUES ('PAGE_DEV_ROLE_TYPES_SEARCH', 6);
INSERT INTO MainMenu(PageName, MainMenuParent) VALUES ('PAGE_DEV_MAINMENU_ADD', 6);
INSERT INTO MainMenu(PageName, MainMenuParent) VALUES ('PAGE_DEV_MAINMENU_SEARCH', 6);
                                                               
INSERT INTO UserTitles (TitleName, TitleDescription) VALUES ('TITLE_ADMIN', 'Yönetici');
INSERT INTO UserTitles (TitleName, TitleDescription) VALUES ('TITLE_DEVELOPER', 'Yazılım Geliştirici');
INSERT INTO UserTitles (TitleName, TitleDescription) VALUES ('TITLE_HRM', 'İnsan Kaynakları');

INSERT INTO UserRoleTypes (RoleName, RoleDescription) VALUES ('ROLE_ALL', 'Hepsi');

INSERT INTO UserRoleTypes (RoleName, PageName, RoleDescription) VALUES ('ROLE_HRM_USER_ADD', 'PAGE_HRM_USER_ADD', 'Kullanıcı oluşturma (IK)');
INSERT INTO UserRoleTypes (RoleName, PageName, RoleDescription) VALUES ('ROLE_HRM_USER_SEARCH', 'PAGE_HRM_USER_SEARCH', 'Kullanıcıları görme (IK)');
INSERT INTO UserRoleTypes (RoleName, PageName, RoleDescription) VALUES ('ROLE_HRM_USER_UPDATE', 'PAGE_HRM_USER_UPDATE', 'Kullanıcı güncelleme (IK)');
INSERT INTO UserRoleTypes (RoleName, PageName, RoleDescription) VALUES ('ROLE_HRM_USER_REMOVE', 'PAGE_HRM_USER_REMOVE', 'Kullanıcı silme (IK)');
INSERT INTO UserRoleTypes (RoleName, PageName, RoleDescription) VALUES ('ROLE_HRM_USER_PASSWORD_RESET', 'PAGE_HRM_USER_PASSWORD_RESET', 'Parola sıfırlama (IK)');

INSERT INTO UserRoleTypes (RoleName, PageName, RoleDescription) VALUES ('ROLE_DEV_PAGE_ADD', 'PAGE_DEV_PAGE_ADD', 'Sayfa oluşturma (Geliştirici)');
INSERT INTO UserRoleTypes (RoleName, PageName, RoleDescription) VALUES ('ROLE_DEV_PAGE_SEARCH', 'PAGE_DEV_PAGE_SEARCH', 'Sayfaları görme (Geliştirici)');
INSERT INTO UserRoleTypes (RoleName, PageName, RoleDescription) VALUES ('ROLE_DEV_PAGE_UPDATE', 'PAGE_DEV_PAGE_UPDATE', 'Sayfa güncelleme (Geliştirici)');
INSERT INTO UserRoleTypes (RoleName, PageName, RoleDescription) VALUES ('ROLE_DEV_PAGE_REMOVE', 'PAGE_DEV_PAGE_REMOVE', 'Sayfa silme (Geliştirici)');

INSERT INTO UserRoleTypes (RoleName, PageName, RoleDescription) VALUES ('ROLE_DEV_SQL_SELECT', 'PAGE_DEV_SQL_SELECT', 'Query ile veri çekme (Geliştirici)');
INSERT INTO UserRoleTypes (RoleName, PageName, RoleDescription) VALUES ('ROLE_DEV_SQL_EXECUTE', 'PAGE_DEV_SQL_EXECUTE', 'Veritabanı query işlem yapma (Geliştirici)');

INSERT INTO UserRoleTypes (RoleName, PageName, RoleDescription) VALUES ('ROLE_HRM_USER_TITLES_ADD', 'PAGE_HRM_USER_TITLES_ADD', 'Kullanıcı ünvanı oluşturma (IK)');
INSERT INTO UserRoleTypes (RoleName, PageName, RoleDescription) VALUES ('ROLE_HRM_USER_TITLES_SEARCH', 'PAGE_HRM_USER_TITLES_SEARCH', 'Kullanıcı ünvanlarını görme (IK)');
INSERT INTO UserRoleTypes (RoleName, PageName, RoleDescription) VALUES ('ROLE_HRM_USER_TITLES_UPDATE', 'PAGE_HRM_USER_TITLES_UPDATE', 'Kullanıcı ünvanı güncelleme (IK)');
INSERT INTO UserRoleTypes (RoleName, PageName, RoleDescription) VALUES ('ROLE_HRM_USER_TITLES_REMOVE', 'PAGE_HRM_USER_TITLES_REMOVE', 'Kullanıcı ünvanı silme (IK)');

INSERT INTO UserRoleTypes (RoleName, PageName, RoleDescription) VALUES ('ROLE_DEV_ROLE_TYPES_ADD', 'PAGE_DEV_ROLE_TYPES_ADD', 'Kullanıcı rolü oluşturma (Geliştirici)');
INSERT INTO UserRoleTypes (RoleName, PageName, RoleDescription) VALUES ('ROLE_DEV_ROLE_TYPES_SEARCH', 'PAGE_DEV_ROLE_TYPES_SEARCH', 'Kullanıcı rollerini görme (Geliştirici)');
INSERT INTO UserRoleTypes (RoleName, PageName, RoleDescription) VALUES ('ROLE_DEV_ROLE_TYPES_UPDATE', 'PAGE_DEV_ROLE_TYPES_UPDATE', 'Kullanıcı rolü güncelleme (Geliştirici)');
INSERT INTO UserRoleTypes (RoleName, PageName, RoleDescription) VALUES ('ROLE_DEV_ROLE_TYPES_REMOVE', 'PAGE_DEV_ROLE_TYPES_REMOVE', 'Kullanıcı rolü silme (Geliştirici)');


INSERT INTO UserRoleTypes (RoleName, PageName, RoleDescription) VALUES ('ROLE_DEV_MAINMENU_ADD', 'PAGE_DEV_MAINMENU_ADD', 'Ana menü oluşturma (Geliştirici)');
INSERT INTO UserRoleTypes (RoleName, PageName, RoleDescription) VALUES ('ROLE_DEV_MAINMENU_SEARCH', 'PAGE_DEV_MAINMENU_SEARCH', 'Ana menüleri görme (Geliştirici)');
INSERT INTO UserRoleTypes (RoleName, PageName, RoleDescription) VALUES ('ROLE_DEV_MAINMENU_UPDATE', 'PAGE_DEV_MAINMENU_UPDATE', 'Ana menü güncelleme (Geliştirici)');
INSERT INTO UserRoleTypes (RoleName, PageName, RoleDescription) VALUES ('ROLE_DEV_MAINMENU_REMOVE', 'PAGE_DEV_MAINMENU_REMOVE', 'Ana menü silme (Geliştirici)');

INSERT INTO UserRoleTypes (RoleName, PageName, RoleDescription) VALUES ('ROLE_HRM_TITLE_ROLES_ADD', 'PAGE_HRM_TITLE_ROLES_ADD', 'Ünvan rolü oluşturma (IK)');
INSERT INTO UserRoleTypes (RoleName, PageName, RoleDescription) VALUES ('ROLE_HRM_TITLE_ROLES_SEARCH', 'PAGE_HRM_TITLE_ROLES_SEARCH', 'Ünvan rollerini görme (IK)');
INSERT INTO UserRoleTypes (RoleName, PageName, RoleDescription) VALUES ('ROLE_HRM_TITLE_ROLES_UPDATE', 'PAGE_HRM_TITLE_ROLES_UPDATE', 'Ünvan rolü güncelleme (IK)');
INSERT INTO UserRoleTypes (RoleName, PageName, RoleDescription) VALUES ('ROLE_HRM_TITLE_ROLES_REMOVE', 'PAGE_HRM_TITLE_ROLES_REMOVE', 'Ünvan rolü silme (IK)');

INSERT INTO UserTitleRoles (TitleName, RoleName) VALUES ('TITLE_ADMIN', 'ROLE_ALL');

INSERT INTO UserTitleRoles (TitleName, RoleName) VALUES ('TITLE_HRM', 'ROLE_HRM_USER_ADD');
INSERT INTO UserTitleRoles (TitleName, RoleName) VALUES ('TITLE_HRM', 'ROLE_HRM_USER_SEARCH');
INSERT INTO UserTitleRoles (TitleName, RoleName) VALUES ('TITLE_HRM', 'ROLE_HRM_USER_UPDATE');
INSERT INTO UserTitleRoles (TitleName, RoleName) VALUES ('TITLE_HRM', 'ROLE_HRM_USER_REMOVE');
INSERT INTO UserTitleRoles (TitleName, RoleName) VALUES ('TITLE_HRM', 'ROLE_HRM_USER_PASSWORD_RESET');
INSERT INTO UserTitleRoles (TitleName, RoleName) VALUES ('TITLE_HRM', 'ROLE_HRM_USER_TITLES_ADD');
INSERT INTO UserTitleRoles (TitleName, RoleName) VALUES ('TITLE_HRM', 'ROLE_HRM_USER_TITLES_SEARCH');
INSERT INTO UserTitleRoles (TitleName, RoleName) VALUES ('TITLE_HRM', 'ROLE_HRM_USER_TITLES_UPDATE');
INSERT INTO UserTitleRoles (TitleName, RoleName) VALUES ('TITLE_HRM', 'ROLE_HRM_USER_TITLES_REMOVE');
INSERT INTO UserTitleRoles (TitleName, RoleName) VALUES ('TITLE_HRM', 'ROLE_HRM_TITLE_ROLES_ADD');
INSERT INTO UserTitleRoles (TitleName, RoleName) VALUES ('TITLE_HRM', 'ROLE_HRM_TITLE_ROLES_SEARCH');
INSERT INTO UserTitleRoles (TitleName, RoleName) VALUES ('TITLE_HRM', 'ROLE_HRM_TITLE_ROLES_UPDATE');
INSERT INTO UserTitleRoles (TitleName, RoleName) VALUES ('TITLE_HRM', 'ROLE_HRM_TITLE_ROLES_REMOVE');

INSERT INTO UserTitleRoles (TitleName, RoleName) VALUES ('TITLE_DEVELOPER', 'ROLE_DEV_PAGE_ADD');
INSERT INTO UserTitleRoles (TitleName, RoleName) VALUES ('TITLE_DEVELOPER', 'ROLE_DEV_PAGE_SEARCH');
INSERT INTO UserTitleRoles (TitleName, RoleName) VALUES ('TITLE_DEVELOPER', 'ROLE_DEV_PAGE_UPDATE');
INSERT INTO UserTitleRoles (TitleName, RoleName) VALUES ('TITLE_DEVELOPER', 'ROLE_DEV_PAGE_REMOVE');
INSERT INTO UserTitleRoles (TitleName, RoleName) VALUES ('TITLE_DEVELOPER', 'ROLE_DEV_SQL_SELECT');
INSERT INTO UserTitleRoles (TitleName, RoleName) VALUES ('TITLE_DEVELOPER', 'ROLE_DEV_SQL_EXECUTE');
INSERT INTO UserTitleRoles (TitleName, RoleName) VALUES ('TITLE_DEVELOPER', 'ROLE_DEV_ROLE_TYPES_ADD');
INSERT INTO UserTitleRoles (TitleName, RoleName) VALUES ('TITLE_DEVELOPER', 'ROLE_DEV_ROLE_TYPES_SEARCH');
INSERT INTO UserTitleRoles (TitleName, RoleName) VALUES ('TITLE_DEVELOPER', 'ROLE_DEV_ROLE_TYPES_UPDATE');
INSERT INTO UserTitleRoles (TitleName, RoleName) VALUES ('TITLE_DEVELOPER', 'ROLE_DEV_ROLE_TYPES_REMOVE');
INSERT INTO UserTitleRoles (TitleName, RoleName) VALUES ('TITLE_DEVELOPER', 'ROLE_DEV_MAINMENU_ADD');
INSERT INTO UserTitleRoles (TitleName, RoleName) VALUES ('TITLE_DEVELOPER', 'ROLE_DEV_MAINMENU_SEARCH');
INSERT INTO UserTitleRoles (TitleName, RoleName) VALUES ('TITLE_DEVELOPER', 'ROLE_DEV_MAINMENU_UPDATE');
INSERT INTO UserTitleRoles (TitleName, RoleName) VALUES ('TITLE_DEVELOPER', 'ROLE_DEV_MAINMENU_REMOVE');

INSERT INTO User (UserEmail, UserName, UserSurname, UserPhone, UserPassword, TitleName) VALUES ('anildogru07@gmail.com', 'Anıl', 'Doğru', '5069540105', 'c8837b23ff8aaa8a2dde915473ce0991', 'TITLE_ADMIN');
