--assign uniqueidentifier in a variable
DECLARE @GUID uniqueidentifier
SET @GUID = NEWID()

--Drop tables
-- Drop the i_pending_message.
	IF EXISTS (SELECT * FROM sys.objects 
		WHERE object_id = OBJECT_ID(N'[dbo].[i_pending_message]') 
		AND type in (N'U'))
	DROP TABLE [dbo].[i_pending_message]



-- Create the i_pending_message table.

	
	BEGIN
		CREATE TABLE [dbo].[i_pending_message](
			[MessageID] [int] IDENTITY(1,1) NOT NULL,
			[GUID] [char](36) NOT NULL DEFAULT NEWID()  PRIMARY KEY, -- GUID
			[FromUserGUID] [char](36) NOT NULL,  -- GUID
			[TargetUserGUID] [char](36) NOT NULL,  -- GUID
			[MessageContent] [nvarchar](max) NOT NULL,		
			[MessageReviewStatus] [char] NOT NULL default 0, -- 0:等待審核 1: 審核不通過 2: 審核通過
			[MessageReviewTime] [datetime]  NULL , -- 審核時間
			[MessageReviewRejectReason] [nvarchar](30) NULL , --訊息審核未通過原因
			[MessageReviewByGUID] [char](36) NULL,  -- GUID
			[DateCreate] [datetime] NOT NULL default CURRENT_TIMESTAMP,	-- 資料建立時間
			[DateModify] [datetime] NOT NULL default CURRENT_TIMESTAMP,  -- 更新資料時間
			FOREIGN KEY (FromUserGUID) REFERENCES i_user(GUID),
			FOREIGN KEY (TargetUserGUID) REFERENCES i_user(GUID),
			FOREIGN KEY (MessageReviewByGUID) REFERENCES i_user(GUID)
			
		) 
	END;
    GO
