--assign uniqueidentifier in a variable
DECLARE @GUID uniqueidentifier
SET @GUID = NEWID()

--Drop tables
-- Drop the i_fortune_message.
	IF EXISTS (SELECT * FROM sys.objects 
		WHERE object_id = OBJECT_ID(N'[dbo].[i_fortune_message]') 
		AND type in (N'U'))
	DROP TABLE [dbo].[i_fortune_message]

-- Drop the i_fortune.
	IF EXISTS (SELECT * FROM sys.objects 
		WHERE object_id = OBJECT_ID(N'[dbo].[i_fortune]') 
		AND type in (N'U'))
	DROP TABLE [dbo].[i_fortune]


-- Create the i_wish table.

	
	BEGIN
		CREATE TABLE [dbo].[i_fortune](
			[FortuneID] [int] IDENTITY(2987,1) NOT NULL,
			[GUID] [char](36) NOT NULL DEFAULT NEWID()  PRIMARY KEY, -- GUID
			[Services] [tinyint] NOT NULL default 0, --服務項目 0 : 批流年，1:論命
			[UserGUID] [char](36) NOT NULL  
					REFERENCES [dbo].[i_user](GUID)						
					ON DELETE CASCADE, 
			[Nickname] [nvarchar](128)  NULL,	-- 匿稱
			[Role] [nvarchar](10) NOT NULL default 'female', -- 帳戶類型0:Girl , 1:Daddy

			[Birthday] [datetime] NOT NULL, -- 出生日期
			[BornHour] [tinyint] NOT NULL, -- 出生時辰
			[Lunar] [nvarchar](50) NOT NULL, -- 出生日期
			[Maritalstatus] [nvarchar](30) NULL default NULL, --婚姻狀態
			--[Request] [nvarchar](max) NULL default NULL, -- 問題(可不填)
			[PblmEmail] [nvarchar](255) NOT NULL , -- 聯絡用 email,存最後一次資料
			[PblmTel] [nvarchar](255) NOT NULL , -- 聯絡方式,存最後一次資料
			[PaymentStatus] [tinyint] NOT NULL default 0, --付費註記 0 : 等待付費，1:不需付費 :已付費，
			[DatePayment] [datetime] NULL default NULL,	-- 付費註記時間
			[NotifyPaymentStatus] [tinyint] NOT NULL default 0, --通知付費註記 0 : 等待通知 ; 1:已通知付費
			[DateNotifyPayment] [datetime] NULL default NULL,	-- 通知付費註記時間

			[FortuneStatus] [tinyint] NOT NULL default 0, --算命註記 0 : 等待定盤，1 : 定盤確認開始分析 2:分析結束
			[ST] [bit] NOT NULL default 0, --取消註記 0 : 未取消，1:己取消 [PaymentStatus] = 0 AND [FortuneStatus] = 0 才可取消
			[DateST] [datetime] NULL default NULL,	-- 取消註記時間
			[MT] [bit] NOT NULL default 0, --審結註記 0 : 未審結，1:己審結
			[DateMT] [datetime] NULL default NULL,	-- 審結註記時間

			[TypeDiscussion] [tinyint] NOT NULL default 0, --論命方式 0 : 線上，1:通訊工具，2:面對面
			[LocationDiscussion] [nvarchar](256) NULL default NULL, --預定論命地點
			[DateDiscussion] [datetime] NULL default NULL,	-- 預定論命日期
			[DateCreate] [datetime] NOT NULL default CURRENT_TIMESTAMP,	-- 建立資料時間
			[DateModify] [datetime] NOT NULL default CURRENT_TIMESTAMP  -- 更新資料時間


		) 
	END;
    GO
	