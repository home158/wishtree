--assign uniqueidentifier in a variable
DECLARE @GUID uniqueidentifier
SET @GUID = NEWID()

--Drop tables
-- Drop the i_photo_privilege.
	IF EXISTS (SELECT * FROM sys.objects 
		WHERE object_id = OBJECT_ID(N'[dbo].[i_photo_privilege]') 
		AND type in (N'U'))
	DROP TABLE [dbo].[i_photo_privilege]


-- Create the i_photo_privilege table.

	
	BEGIN
		CREATE TABLE [dbo].[i_photo_privilege](
			[PrivilegeID] [int] IDENTITY(1,1) NOT NULL,
			[GUID] [char](36) NOT NULL DEFAULT NEWID()  PRIMARY KEY, -- GUID
			[UserGUID] [char](36) NOT NULL  
					REFERENCES [dbo].[i_user](GUID)						
					ON DELETE CASCADE, 
			[TrackUserGUID] [char](36) NOT NULL,  -- GUID
			[Privilege] [char](1) NOT NULL default 0, --權限註記 0:請求權限 1 : 黑名單 ，2:給予權限
			[DateCreate] [datetime] NOT NULL default CURRENT_TIMESTAMP,	-- 建立資料時間
			[DateModify] [datetime] NOT NULL default CURRENT_TIMESTAMP  -- 更新資料時間


		) 
	END;
    GO
	