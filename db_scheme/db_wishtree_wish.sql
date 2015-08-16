--assign uniqueidentifier in a variable
DECLARE @GUID uniqueidentifier
SET @GUID = NEWID()

--Drop tables
-- Drop the i_wish.
	IF EXISTS (SELECT * FROM sys.objects 
		WHERE object_id = OBJECT_ID(N'[dbo].[i_wish]') 
		AND type in (N'U'))
	DROP TABLE [dbo].[i_wish]


-- Create the i_wish table.

	
	BEGIN
		CREATE TABLE [dbo].[i_wish](
			[WishID] [int] IDENTITY(1,1) NOT NULL,
			[GUID] [char](36) NOT NULL DEFAULT NEWID()  PRIMARY KEY, -- GUID
			[UserGUID] [char](36) NOT NULL  
					REFERENCES [dbo].[i_user](GUID)						
					ON DELETE CASCADE, 

			[WishCategory] [nvarchar](20) NOT NULL default 'other',
			[WishTitle] [nvarchar](256) NOT NULL,
			[WishContent] [nvarchar](max) NOT NULL,
			[WishReviewStatus] [char] NOT NULL default 0, -- 0:等待審核 1: 審核不通過 2: 審核通過
			[WishReviewDate] [datetime]  NULL , -- 審核時間
			[WishReviewRejectReason] [nvarchar](30) NULL , --願望審核未通過原因

			
			[DeleteStatus] [bit] NOT NULL default 0, -- 刪除註記 0:非刪除 1:刪除
			[DeleteDate]  [datetime] NULL, --刪除註記時間

			[MothballStatus] [bit] NOT NULL default 0, -- 封存註記 0:非封存 1:封存
			[MothballDate]  [datetime] NULL, --封存註記時間
			[DateExpire] [datetime] NOT NULL default CURRENT_TIMESTAMP,	-- 資料過期時間
			[DateCreate] [datetime] NOT NULL default CURRENT_TIMESTAMP,	-- 建立資料時間
			[DateModify] [datetime] NOT NULL default CURRENT_TIMESTAMP  -- 更新資料時間


		) 
	END;
    GO
	