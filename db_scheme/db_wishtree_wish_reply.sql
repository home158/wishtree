--assign uniqueidentifier in a variable
DECLARE @GUID uniqueidentifier
SET @GUID = NEWID()

--Drop tables
-- Drop the i_wish_reply.
	IF EXISTS (SELECT * FROM sys.objects 
		WHERE object_id = OBJECT_ID(N'[dbo].[i_wish_reply]') 
		AND type in (N'U'))
	DROP TABLE [dbo].[i_wish_reply]


-- Create the i_wish_reply table.

	
	BEGIN
		CREATE TABLE [dbo].[i_wish_reply](
			[ReplyID] [int] IDENTITY(1,1) NOT NULL,
			[GUID] [char](36) NOT NULL DEFAULT NEWID()  PRIMARY KEY, -- GUID
			[WishGUID] [char](36) NOT NULL  
					REFERENCES [dbo].[i_wish](GUID)
					ON DELETE CASCADE, 
			[UserGUID] [char](36) NOT NULL  
					REFERENCES [dbo].[i_user](GUID), 

			[ReplyContent] [nvarchar](max) NOT NULL,

			[DateCreate] [datetime] NOT NULL default CURRENT_TIMESTAMP,	-- 建立資料時間
			[DateModify] [datetime] NOT NULL default CURRENT_TIMESTAMP  -- 更新資料時間


		) 
	END;
    GO
	