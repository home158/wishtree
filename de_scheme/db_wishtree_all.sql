--assign uniqueidentifier in a variable
DECLARE @GUID uniqueidentifier
SET @GUID = NEWID()

--Drop tables
-- Drop the i_user.
	IF EXISTS (SELECT * FROM sys.objects 
		WHERE object_id = OBJECT_ID(N'[dbo].[i_user]') 
		AND type in (N'U'))
	DROP TABLE [dbo].[i_user]


-- Create the i_user table.

	
	BEGIN
		CREATE TABLE [dbo].[i_user](
			[UserID] [int] IDENTITY(1,1) NOT NULL,
			
			[GUID] [char](36) NOT NULL  PRIMARY KEY DEFAULT NEWID() , -- GUID
			[Nickname] [nvarchar](128)  NULL,	-- 匿稱
			[Role] [nvarchar](10) NOT NULL default 'female', -- 帳戶類型0:Girl , 1:Daddy
			[Email] [nvarchar](255) NOT NULL , -- 登入用 email;
			[Password] [nvarchar](20) NULL, -- 密碼
			[PasswordEncrypt] [char](32) NOT NULL, -- 加密後密碼;
			[AboutMe] [nvarchar](max) NOT NULL, -- 關於我
			[Natinal] [char](2) NOT NULL, -- 國籍
			[City] [nvarchar](3) NOT NULL, -- 城市
			[Language] [nvarchar](20) NOT NULL, -- 慣用語言
			[Income] [nvarchar](30) NOT NULL,-- 年收入
			[Property] [nvarchar](30) NOT NULL,-- 總資產
			[Birthday] [datetime] NOT NULL, -- 出生日期
			[Height] [nvarchar](30) NOT NULL,--身高
			[Bodytype] [nvarchar](30) NOT NULL,--體型
			[Race] [nvarchar](30) NOT NULL,--種族
			[Education] [nvarchar](30) NULL default NULL, --教育程度
			[Maritalstatus] [nvarchar](30) NULL default NULL, --婚姻狀態
			[Smoking] [nvarchar](30) NULL default NULL,--吸菸習慣
			[Drinking] [nvarchar](30) NULL default NULL,--飲酒習慣
			[IdealDesc] [nvarchar](max) NULL, -- 理想中的約會對象
			
			[ValidateKey] [char](36) NULL, -- 註冊驗證碼
			[LastLoginTime] [datetime] NOT NULL  default CURRENT_TIMESTAMP,						-- 最後登入時間
			[DateValidate] [char](36) NULL, -- 驗證時間
			[DateCreate] [datetime] NOT NULL default CURRENT_TIMESTAMP,	-- 註冊資料時間
			[DateModify] [datetime] NOT NULL default CURRENT_TIMESTAMP  -- 更新資料時間

		) 
	END;
    GO
