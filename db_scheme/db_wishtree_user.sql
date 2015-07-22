--assign uniqueidentifier in a variable
DECLARE @GUID uniqueidentifier
SET @GUID = NEWID()

--Drop tables
-- Drop the i_photo.
	IF EXISTS (SELECT * FROM sys.objects 
		WHERE object_id = OBJECT_ID(N'[dbo].[i_photo]') 
		AND type in (N'U'))
	DROP TABLE [dbo].[i_photo]
-- Drop the i_user.
	IF EXISTS (SELECT * FROM sys.objects 
		WHERE object_id = OBJECT_ID(N'[dbo].[i_user]') 
		AND type in (N'U'))
	DROP TABLE [dbo].[i_user]
-- Drop the i_message_box.
	IF EXISTS (SELECT * FROM sys.objects 
		WHERE object_id = OBJECT_ID(N'[dbo].[i_message_box]') 
		AND type in (N'U'))
	DROP TABLE [dbo].[i_message_box]
-- Drop the i_pending_message.
	IF EXISTS (SELECT * FROM sys.objects 
		WHERE object_id = OBJECT_ID(N'[dbo].[i_pending_message]') 
		AND type in (N'U'))
	DROP TABLE [dbo].[i_pending_message]

-- Create the i_user table.

	
	BEGIN
		CREATE TABLE [dbo].[i_user](
			[UserID] [int] IDENTITY(1,1) NOT NULL,
			
			[GUID] [char](36) NOT NULL  PRIMARY KEY DEFAULT NEWID() , -- GUID
			[Nickname] [nvarchar](128)  NULL,	-- 匿稱
			[Role] [nvarchar](10) NOT NULL default 'female', -- 帳戶類型0:Girl , 1:Daddy
			[Email] [nvarchar](255) NOT NULL , -- 登入用 email;
			[Password] [nvarchar](20) NULL, -- 密碼
			[TimezoneOffset] [char](6) NOT NULL default '+00:00', -- 時區;
			[DST] [bit] NOT NULL default 0, -- 日光節約 0:關閉 1:開啟
			[PasswordEncrypt] [char](32) NOT NULL, -- 加密後密碼;
			[Rank] [tinyint] NOT NULL default 1 ,  --權限 0:刪除 1:停權 2:註冊未認證; 3:已認證會員; ........ 255:站長;
			[ForbiddenMsg] [nvarchar](128) NULL, -- 停權原因
			[AboutMe] [nvarchar](max) NOT NULL, -- 關於我
			[NationalCode] [char](2) NOT NULL, -- 國籍
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
			[Validated] [bit] NOT NULL default 0, --電子郵件證認證註記 0 : 未認證 ，1:己認證
			[ValidatedDate] [datetime] NULL ,	 -- 驗證時間

			[ProfileReviewStatus] [char](1) NOT NULL default 0, --個人資料審核註記 0:等待審核 1 : 未通過 ，2:通過
			[ProfileReviewRejectReason] [nvarchar](30) NULL , --個人資料審核未通過原因
			[ProfileReviewDate]  [datetime] NULL, --個人資料審核時間
			[ProfileLatestUpdateDate]  [datetime] NULL, --個人資料更新時間
			
			[LastLoginTime] [datetime] NOT NULL  default CURRENT_TIMESTAMP,						-- 最後登入時間
			[DateCreate] [datetime] NOT NULL default CURRENT_TIMESTAMP,	-- 註冊資料時間
			[DateModify] [datetime] NOT NULL default CURRENT_TIMESTAMP  -- 更新資料時間

		) 
	END;
    GO
