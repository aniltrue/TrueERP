CREATE TABLE UserTitles (
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
	UserEnable BOOLEAN DEFAULT FALSE,
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

CREATE TABLE UserRoles (
	UserEmail VARCHAR(32) NOT NULL,
	RoleName VARCHAR(32) NOT NULL,
	FOREIGN KEY (UserEmail) REFERENCES User (UserEmail) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (RoleName) REFERENCES UserRoleTypes (RoleName) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE UserTitleRoles (
	TitleName VARCHAR(32) NOT NULL,
	RoleName VARCHAR(32) NOT NULL,
	FOREIGN KEY (TitleName) REFERENCES UserTitles (TitleName) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (RoleName) REFERENCES UserRoleTypes (RoleName) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE ScriptTypes (
	ScriptTypeName VARCHAR(10) NOT NULL UNIQUE,
	PRIMARY KEY (ScriptTypeName);
);

CREATE TABLE Scripts (
	ScriptName VARHCAR(32) NOT NULL UNIQUE,
	ScriptTypeName VARCHAR(10) NOT NULL,
	PRIMARY KEY (ScriptName),
	FOREIGN KEY (ScriptTypeName) REFERENCES ScriptTypes (ScriptTypeName) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE MainMenu (
	MainMenuID INT UNIQUE NOT NULL AUTO_INCREMENT,
	PageName VARCHAR(20),
	MainMenuText VARCHAR(64) DEFAULT '',
	MainMenuParent INT DEFAULT 0,
	PRIMARY KEY (MainMenuID),
	FOREIGN KEY (PageName) REFERENCES Pages (PageName) ON DELETE CASCADE ON UPDATE CASCADE
);

INSERT INTO Pages (PageName, PageURL, PageDescription) VALUES ('PAGE_MAIN', 'main.php', 'AnaSayfa');
INSERT INTO Pages (PageName, PageURL, PageDescription) VALUES ('PAGE_USER_PASSWORD_RESET', 'ChangePassword.php', 'Parola değiştir');

INSERT INTO Pages (PageName, PageURL, PageDescription) VALUES ('PAGE_HRM_USER_ADD', 'CreateUser.php', 'Kullanıcı oluştur');
INSERT INTO Pages (PageName, PageURL, PageDescription) VALUES ('PAGE_HRM_USER_SEARCH', 'Search.php?Type=User', 'Kullanıcı bul');
INSERT INTO Pages (PageName, PageURL, PageDescription) VALUES ('PAGE_HRM_USER_UPDATE', 'Update.php?Type=User', 'Kullanıcıyı güncelle');
INSERT INTO Pages (PageName, PageURL, PageDescription) VALUES ('PAGE_HRM_USER_REMOVE', 'Remove.php?Type=User', 'Kullanıcıyı sil');
INSERT INTO Pages (PageName, PageURL, PageDescription) VALUES ('PAGE_HRM_USER_PASSWORD_RESET', 'ChangePassword.php', 'Parola sıfırla');

INSERT INTO Pages (PageName, PageURL, PageDescription) VALUES ('PAGE_DEV_PAGE_ADD', 'Add.php?Type=Pages', 'Sayfa oluştur');
INSERT INTO Pages (PageName, PageURL, PageDescription) VALUES ('PAGE_DEV_PAGE_SEARCH', 'Search.php?Type=Pages', 'Sayfa bul');
INSERT INTO Pages (PageName, PageURL, PageDescription) VALUES ('PAGE_DEV_PAGE_UPDATE', 'Update.php?Type=Pages', 'Sayfayı güncelle');
INSERT INTO Pages (PageName, PageURL, PageDescription) VALUES ('PAGE_DEV_PAGE_REMOVE', 'Remove.php?Type=Pages', 'Sayfayı sil');

INSERT INTO Pages (PageName, PageURL, PageDescription) VALUES ('PAGE_DEV_SCRIPT_ADD', 'Add.php?Type=Scripts', 'Script oluştur');
INSERT INTO Pages (PageName, PageURL, PageDescription) VALUES ('PAGE_DEV_SCRIPT_SEARCH', 'Search.php?Type=Scripts', 'Script bul');
INSERT INTO Pages (PageName, PageURL, PageDescription) VALUES ('PAGE_DEV_SCRIPT_UPDATE', 'Update.php?Type=Scripts', 'Scripti güncelle');
INSERT INTO Pages (PageName, PageURL, PageDescription) VALUES ('PAGE_DEV_SCRIPT_REMOVE', ''Remove.php?Type=Scripts', 'Scripti sil');							       
							       
INSERT INTO Pages (PageName, PageURL, PageDescription) VALUES ('PAGE_HRM_USER_TITLES_ADD', 'Add.php?Type=UserTitles', 'Kullanıcı ünvanı oluştur');
INSERT INTO Pages (PageName, PageURL, PageDescription) VALUES ('PAGE_HRM_USER_TITLES_SEARCH', 'Search.php?Type=UserTitles', 'Kullanıcı ünvanı bul');
INSERT INTO Pages (PageName, PageURL, PageDescription) VALUES ('PAGE_HRM_USER_TITLES_UPDATE', 'Update.php?Type=UserTitles', 'Kullanıcı ünvanını güncelle');
INSERT INTO Pages (PageName, PageURL, PageDescription) VALUES ('PAGE_HRM_USER_TITLES_REMOVE', ''Remove.php?Type=UserTitles', 'Kullanıcı ünvanını sil');																														 

INSERT INTO Pages (PageName, PageURL, PageDescription) VALUES ('PAGE_DEV_MAINMENU_ADD', 'Add.php?Type=MainMenu', 'Ana menü oluştur');
INSERT INTO Pages (PageName, PageURL, PageDescription) VALUES ('PAGE_DEV_MAINMENU_SEARCH', 'Search.php?Type=MainMenu', 'Ana menü bul');
INSERT INTO Pages (PageName, PageURL, PageDescription) VALUES ('PAGE_DEV_MAINMENU_UPDATE', 'Update.php?Type=MainMenu', 'Ana menüyü güncelle');
INSERT INTO Pages (PageName, PageURL, PageDescription) VALUES ('PAGE_DEV_MAINMENU_REMOVE', ''Remove.php?Type=MainMenu', 'Ana menüyü sil');

INSERT INTO Pages (PageName, PageURL, PageDescription) VALUES ('PAGE_HRM_TITLE_ROLES_ADD', 'Add.php?Type=TitleRoles', 'Ünvan rolü oluştur');
INSERT INTO Pages (PageName, PageURL, PageDescription) VALUES ('PAGE_HRM_TITLE_ROLES_SEARCH', 'Search.php?Type=TitleRoles', 'Ünvan rolü bul');
INSERT INTO Pages (PageName, PageURL, PageDescription) VALUES ('PAGE_HRM_TITLE_ROLES_UPDATE', 'Update.php?Type=TitleRoles', 'Ünvan rolünü güncelle');
INSERT INTO Pages (PageName, PageURL, PageDescription) VALUES ('PAGE_HRM_TITLE_ROLES_REMOVE', ''Remove.php?Type=TitleRoles', 'Ünvan rolünü sil');								       

INSERT INTO Pages (PageName, PageURL, PageDescription) VALUES ('PAGE_HRM_USER_ROLES_ADD', 'Add.php?Type=UserRoles', 'Kullanıcı rolü oluştur');
INSERT INTO Pages (PageName, PageURL, PageDescription) VALUES ('PAGE_HRM_USER_ROLES_SEARCH', 'Search.php?Type=UserRoles', 'Kullanıcı rolü bul');
INSERT INTO Pages (PageName, PageURL, PageDescription) VALUES ('PAGE_HRM_USER_ROLES_UPDATE', 'Update.php?Type=UserRoles', 'Kullanıcı rolünü güncelle');
INSERT INTO Pages (PageName, PageURL, PageDescription) VALUES ('PAGE_HRM_USER_ROLES_REMOVE', ''Remove.php?Type=UserRoles', 'Kullanıcı rolünü sil');

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

INSERT INTO UserRoleTypes (RoleName, PageName, RoleDescription) VALUES ('ROLE_DEV_SCRIPT_ADD', 'PAGE_DEV_SCRIPT_ADD', 'Script oluşturma (Geliştirici)');
INSERT INTO UserRoleTypes (RoleName, PageName, RoleDescription) VALUES ('ROLE_DEV_SCRIPT_SEARCH', 'PAGE_DEV_SCRIPT_SEARCH', 'Scriptleri görme (Geliştirici)');
INSERT INTO UserRoleTypes (RoleName, PageName, RoleDescription) VALUES ('ROLE_DEV_SCRIPT_UPDATE', 'PAGE_DEV_SCRIPT_UPDATE', 'Script güncelleme (Geliştirici)');
INSERT INTO UserRoleTypes (RoleName, PageName, RoleDescription) VALUES ('ROLE_DEV_SCRIPT_REMOVE', 'PAGE_DEV_SCRIPT_REMOVE', 'Script silme (Geliştirici)');

INSERT INTO UserRoleTypes (RoleName, PageName, RoleDescription) VALUES ('ROLE_HRM_USER_TITLES_ADD', 'PAGE_HRM_USER_TITLES_ADD', 'Kullanıcı ünvanı oluşturma (IK)');
INSERT INTO UserRoleTypes (RoleName, PageName, RoleDescription) VALUES ('ROLE_HRM_USER_TITLES_SEARCH', 'PAGE_HRM_USER_TITLES_SEARCH', 'Kullanıcı ünvanlarını görme (IK)');
INSERT INTO UserRoleTypes (RoleName, PageName, RoleDescription) VALUES ('ROLE_HRM_USER_TITLES_UPDATE', 'PAGE_HRM_USER_TITLES_UPDATE', 'Kullanıcı ünvanı güncelleme (IK)');
INSERT INTO UserRoleTypes (RoleName, PageName, RoleDescription) VALUES ('ROLE_HRM_USER_TITLES_REMOVE', 'PAGE_HRM_USER_TITLES_REMOVE', 'Kullanıcı ünvanı silme (IK)');

INSERT INTO UserRoleTypes (RoleName, PageName, RoleDescription) VALUES ('ROLE_DEV_MAINMENU_ADD', 'PAGE_DEV_MAINMENU_ADD', 'Ana menü oluşturma (Geliştirici)');
INSERT INTO UserRoleTypes (RoleName, PageName, RoleDescription) VALUES ('ROLE_DEV_MAINMENU_SEARCH', 'PAGE_DEV_MAINMENU_SEARCH', 'Ana menüleri görme (Geliştirici)');
INSERT INTO UserRoleTypes (RoleName, PageName, RoleDescription) VALUES ('ROLE_DEV_MAINMENU_UPDATE', 'PAGE_DEV_MAINMENU_UPDATE', 'Ana menü güncelleme (Geliştirici)');
INSERT INTO UserRoleTypes (RoleName, PageName, RoleDescription) VALUES ('ROLE_DEV_MAINMENU_REMOVE', 'PAGE_DEV_MAINMENU_REMOVE', 'Ana menü silme (Geliştirici)');

INSERT INTO UserRoleTypes (RoleName, PageName, RoleDescription) VALUES ('ROLE_HRM_TITLE_ROLES_ADD', 'PAGE_HRM_TITLE_ROLES_ADD', 'Ünvan rolü oluşturma (IK)');
INSERT INTO UserRoleTypes (RoleName, PageName, RoleDescription) VALUES ('ROLE_HRM_TITLE_ROLES_SEARCH', 'PAGE_HRM_TITLE_ROLES_SEARCH', 'Ünvan rollerini görme (IK)');
INSERT INTO UserRoleTypes (RoleName, PageName, RoleDescription) VALUES ('ROLE_HRM_TITLE_ROLES_UPDATE', 'PAGE_HRM_TITLE_ROLES_UPDATE', 'Ünvan rolü güncelleme (IK)');
INSERT INTO UserRoleTypes (RoleName, PageName, RoleDescription) VALUES ('ROLE_HRM_TITLE_ROLES_REMOVE', 'PAGE_HRM_TITLE_ROLES_REMOVE', 'Ünvan rolü silme (IK)');

INSERT INTO UserRoleTypes (RoleName, PageName, RoleDescription) VALUES ('ROLE_HRM_USER_ROLES_ADD', 'PAGE_HRM_USER_ROLES_ADD', 'Kullanıcı rolleri oluşturma (IK)');
INSERT INTO UserRoleTypes (RoleName, PageName, RoleDescription) VALUES ('ROLE_HRM_USER_ROLES_SEARCH', 'PAGE_HRM_USER_ROLES_SEARCH', 'Kullanıcı rollerini görme (IK)');
INSERT INTO UserRoleTypes (RoleName, PageName, RoleDescription) VALUES ('ROLE_HRM_USER_ROLES_UPDATE', 'PAGE_HRM_USER_ROLES_UPDATE', 'Kullanıcı rolleri güncelleme (IK)');
INSERT INTO UserRoleTypes (RoleName, PageName, RoleDescription) VALUES ('ROLE_HRM_USER_ROLES_REMOVE', 'PAGE_HRM_USER_ROLES_REMOVE', 'Kullanıcı rolleri silme (IK)');

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
INSERT INTO UserTitleRoles (TitleName, RoleName) VALUES ('TITLE_HRM', 'ROLE_HRM_USER_ROLES_ADD');
INSERT INTO UserTitleRoles (TitleName, RoleName) VALUES ('TITLE_HRM', 'ROLE_HRM_USER_ROLES_SEARCH');
INSERT INTO UserTitleRoles (TitleName, RoleName) VALUES ('TITLE_HRM', 'ROLE_HRM_USER_ROLES_UPDATE');
INSERT INTO UserTitleRoles (TitleName, RoleName) VALUES ('TITLE_HRM', 'ROLE_HRM_USER_ROLES_REMOVE');

INSERT INTO UserTitleRoles (TitleName, RoleName) VALUES ('TITLE_DEVELOPER', 'ROLE_DEV_PAGE_ADD');
INSERT INTO UserTitleRoles (TitleName, RoleName) VALUES ('TITLE_DEVELOPER', 'ROLE_DEV_PAGE_SEARCH');
INSERT INTO UserTitleRoles (TitleName, RoleName) VALUES ('TITLE_DEVELOPER', 'ROLE_DEV_PAGE_UPDATE');
INSERT INTO UserTitleRoles (TitleName, RoleName) VALUES ('TITLE_DEVELOPER', 'ROLE_DEV_PAGE_REMOVE');
INSERT INTO UserTitleRoles (TitleName, RoleName) VALUES ('TITLE_DEVELOPER', 'ROLE_DEV_SCRIPT_ADD');
INSERT INTO UserTitleRoles (TitleName, RoleName) VALUES ('TITLE_DEVELOPER', 'ROLE_DEV_SCRIPT_SEARCH');
INSERT INTO UserTitleRoles (TitleName, RoleName) VALUES ('TITLE_DEVELOPER', 'ROLE_DEV_SCRIPT_UPDATE');
INSERT INTO UserTitleRoles (TitleName, RoleName) VALUES ('TITLE_DEVELOPER', 'ROLE_DEV_SCRIPT_REMOVE');
INSERT INTO UserTitleRoles (TitleName, RoleName) VALUES ('TITLE_DEVELOPER', 'ROLE_DEV_MAINMENU_ADD');
INSERT INTO UserTitleRoles (TitleName, RoleName) VALUES ('TITLE_DEVELOPER', 'ROLE_DEV_MAINMENU_SEARCH');
INSERT INTO UserTitleRoles (TitleName, RoleName) VALUES ('TITLE_DEVELOPER', 'ROLE_DEV_MAINMENU_UPDATE');
INSERT INTO UserTitleRoles (TitleName, RoleName) VALUES ('TITLE_DEVELOPER', 'ROLE_DEV_MAINMENU_REMOVE');

INSERT INTO User (UserEmail, UserName, UserSurname, UserPhone, UserPassword, TitleName) VALUES ('anildogru07@gmail.com', 'Anıl', 'Doğru', '5069540105', 'b8fac6ae9b038da4d836436c94530031', 'Developer');
INSERT INTO UserRoles (UserEmail, RoleName) VALUES ('anildogru07@gmail.com', 'ROLE_ALL');
