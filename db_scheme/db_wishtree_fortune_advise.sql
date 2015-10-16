--assign uniqueidentifier in a variable
DECLARE @GUID uniqueidentifier
SET @GUID = NEWID()

--Drop tables
-- Drop the i_fortune_message.
	IF EXISTS (SELECT * FROM sys.objects 
		WHERE object_id = OBJECT_ID(N'[dbo].[i_fortune_advise]') 
		AND type in (N'U'))
	DROP TABLE [dbo].[i_fortune_advise]


-- Create the i_wish table.

	
	BEGIN
		CREATE TABLE [dbo].[i_fortune_advise](
			[FortuneAdviseID] [int] IDENTITY(1,1) NOT NULL,
			[GUID] [char](36) NOT NULL DEFAULT NEWID()  PRIMARY KEY, -- GUID
			[FortuneGUID] [char](36) NOT NULL 
				REFERENCES [dbo].[i_fortune](GUID), -- GUID

			[UserGUID] [char](36) NOT NULL  
					REFERENCES [dbo].[i_user](GUID)						
					ON DELETE CASCADE, 
			
			[AdviseMessage] [nvarchar](max) NULL default NULL, -- 建議
			[Publish]  [char](1) NOT NULL default 0, --發佈給使用者 0:暫存不發佈 1: 發佈
			
			[DateCreate] [datetime] NOT NULL default CURRENT_TIMESTAMP,	-- 建立資料時間
			[DateModify] [datetime] NOT NULL default CURRENT_TIMESTAMP  -- 更新資料時間


		) 
	END;
    GO
	