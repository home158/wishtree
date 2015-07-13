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
			[Container] [nvarchar](36) NOT NULL,
			[FullBasename] [nvarchar](36) NOT NULL,
			[ThumbBasename] [nvarchar](36) NOT NULL,
			[Hits] [int] NOT NULL default 0, -- 被點擊數
			[LastViewDate] [datetime] NOT NULL  default CURRENT_TIMESTAMP,						-- 最後點擊時間
			[DateCreate] [datetime] NOT NULL default CURRENT_TIMESTAMP,	-- 新增資料時間
			

		) 
	END;
    GO
