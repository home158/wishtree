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
			
			[AdviseMessage] [nvarchar](max) NULL default NULL, -- ��ĳ
			[Publish]  [char](1) NOT NULL default 0, --�o�G���ϥΪ� 0:�Ȧs���o�G 1: �o�G
			
			[DateCreate] [datetime] NOT NULL default CURRENT_TIMESTAMP,	-- �إ߸�Ʈɶ�
			[DateModify] [datetime] NOT NULL default CURRENT_TIMESTAMP  -- ��s��Ʈɶ�


		) 
	END;
    GO
	