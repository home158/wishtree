--assign uniqueidentifier in a variable
DECLARE @GUID uniqueidentifier
SET @GUID = NEWID()

--Drop tables
-- Drop the i_photo.
	IF EXISTS (SELECT * FROM sys.objects 
		WHERE object_id = OBJECT_ID(N'[dbo].[i_photo]') 
		AND type in (N'U'))
	DROP TABLE [dbo].[i_photo]


-- Create the i_user table.

	
	BEGIN
		CREATE TABLE [dbo].[i_photo](
			[PhotoID] [int] IDENTITY(1,1) NOT NULL,
			[GUID] [char](36) NOT NULL DEFAULT NEWID()  PRIMARY KEY, -- GUID
			[UserGUID] [char](36) NOT NULL  
					REFERENCES [dbo].[i_user](GUID)						
					ON DELETE CASCADE, 
			[FullBasename] [nvarchar](50) NOT NULL,
			[CropBasename] [nvarchar](50) NOT NULL,
			[ThumbBasename] [nvarchar](50) NOT NULL,
			[Hits] [int] NOT NULL default 0, -- 被點擊數
			[ReviewStatus] [char](1) NOT NULL default 0, --審核註記 0:等待審核 1 : 未通過 ，2:通過
			[ReviewRejectReason] [nvarchar](30)  NULL , --審核未通過原因
			[IsCover] [bit] NOT NULL default 0, -- 封面照片 0 : 否 ，1:是

			[IsPrivate] [bit] NOT NULL default 0, -- 私人照片 0 : 公開 ，1:私人
			[LastViewDate] [datetime] NOT NULL  default CURRENT_TIMESTAMP,						-- 最後點擊時間
			[DateModify] [datetime] NOT NULL default CURRENT_TIMESTAMP,	-- 更新資料時間
			[DateCreate] [datetime] NOT NULL default CURRENT_TIMESTAMP,	-- 新增資料時間
			

		) 
	END;
    GO
