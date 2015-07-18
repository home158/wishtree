--assign uniqueidentifier in a variable
DECLARE @GUID uniqueidentifier
SET @GUID = NEWID()

--Drop tables
-- Drop the i_message_list.
	IF EXISTS (SELECT * FROM sys.objects 
		WHERE object_id = OBJECT_ID(N'[dbo].[i_message_list]') 
		AND type in (N'U'))
	DROP TABLE [dbo].[i_message_list]



-- Create the i_user table.

	
	BEGIN
		CREATE TABLE [dbo].[i_message_list](
			[ListID] [int] IDENTITY(1,1) NOT NULL,
			[GUID] [char](36) NOT NULL DEFAULT NEWID()  PRIMARY KEY, -- GUID
			[UserGUID] [char](36) NOT NULL,  -- GUID
					
			[FromUserGUID] [char](36) NOT NULL ,
			[IsNew] [bit] NOT NULL default 0, -- 0:沒有新訊息 1: 有新訊息
			[ReadTime] [datetime]  NULL , -- 閱讀時間
			
			[DateCreate] [datetime] NOT NULL default CURRENT_TIMESTAMP,	-- 資料建立時間
			[DateModify] [datetime] NOT NULL default CURRENT_TIMESTAMP  -- 更新資料時間
			FOREIGN KEY (UserGUID) REFERENCES i_user(GUID) ON DELETE CASCADE,
			FOREIGN KEY (FromUserGUID) REFERENCES i_user(GUID)

		) 
	END;
    GO
