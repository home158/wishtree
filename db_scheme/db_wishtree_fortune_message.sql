--assign uniqueidentifier in a variable
DECLARE @GUID uniqueidentifier
SET @GUID = NEWID()

--Drop tables
-- Drop the i_fortune_message.
	IF EXISTS (SELECT * FROM sys.objects 
		WHERE object_id = OBJECT_ID(N'[dbo].[i_fortune_message]') 
		AND type in (N'U'))
	DROP TABLE [dbo].[i_fortune_message]


-- Create the i_wish table.

	
	BEGIN
		CREATE TABLE [dbo].[i_fortune_message](
			[FortuneMessageID] [int] IDENTITY(1,1) NOT NULL,
			[GUID] [char](36) NOT NULL DEFAULT NEWID()  PRIMARY KEY, -- GUID
			[FortuneGUID] [char](36) NOT NULL 
				REFERENCES [dbo].[i_fortune](GUID), -- GUID

			[UserGUID] [char](36) NOT NULL  
					REFERENCES [dbo].[i_user](GUID)						
					ON DELETE CASCADE, 
			[PblmEmail] [nvarchar](255) NOT NULL , -- 聯絡用 email,存最後一次資料
			[PblmTel] [nvarchar](255) NOT NULL , -- 聯絡方式,存最後一次資料
			[PblmCode] [nvarchar](5) NOT NULL , -- 問題類別

			[FortuneMessage] [nvarchar](max) NULL default NULL, -- 問題(可不填)
			[ReplyParent][char](36) NULL default NULL, -- GUID
			[DateCreate] [datetime] NOT NULL default CURRENT_TIMESTAMP,	-- 建立資料時間
			[DateModify] [datetime] NOT NULL default CURRENT_TIMESTAMP  -- 更新資料時間


		) 
	END;
    GO
	