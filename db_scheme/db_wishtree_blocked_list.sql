--assign uniqueidentifier in a variable
DECLARE @GUID uniqueidentifier
SET @GUID = NEWID()

--Drop tables
-- Drop the i_blocked_list.
	IF EXISTS (SELECT * FROM sys.objects 
		WHERE object_id = OBJECT_ID(N'[dbo].[i_blocked_list]') 
		AND type in (N'U'))
	DROP TABLE [dbo].[i_blocked_list]


	
	BEGIN
		CREATE TABLE [dbo].[i_blocked_list](
			[BlockedID] [int] IDENTITY(1,1) NOT NULL,
			
			[GUID] [char](36) NOT NULL  PRIMARY KEY DEFAULT NEWID() , -- GUID
			[UserGUID] [char](36) NOT NULL  
					REFERENCES [dbo].[i_user](GUID)						
					ON DELETE CASCADE, 
			[TrackUserGUID] [char](36) NOT NULL,  -- GUID
			[DateCreate] [datetime] NOT NULL default CURRENT_TIMESTAMP,	-- ���U��Ʈɶ�
			[DateModify] [datetime] NOT NULL default CURRENT_TIMESTAMP  -- ��s��Ʈɶ�

		) 
	END;
    GO
