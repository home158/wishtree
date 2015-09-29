--assign uniqueidentifier in a variable
DECLARE @GUID uniqueidentifier
SET @GUID = NEWID()

--Drop tables
-- Drop the i_fortune_message.
	IF EXISTS (SELECT * FROM sys.objects 
		WHERE object_id = OBJECT_ID(N'[dbo].[i_fortune_message]') 
		AND type in (N'U'))
	DROP TABLE [dbo].[i_fortune_message]


-- Create the i_wish table.

	
	BEGIN
		CREATE TABLE [dbo].[i_fortune_message](
			[FortuneMessageID] [int] IDENTITY(1,1) NOT NULL,
			[GUID] [char](36) NOT NULL DEFAULT NEWID()  PRIMARY KEY, -- GUID
			[FortuneGUID] [char](36) NOT NULL 
				REFERENCES [dbo].[i_fortune](GUID), -- GUID

			[UserGUID] [char](36) NOT NULL  
					REFERENCES [dbo].[i_user](GUID)						
					ON DELETE CASCADE, 
			[PblmEmail] [nvarchar](255) NOT NULL , -- �p���� email,�s�̫�@�����
			[PblmTel] [nvarchar](255) NOT NULL , -- �p���覡,�s�̫�@�����
			[PblmCode] [nvarchar](5) NOT NULL , -- ���D���O

			[FortuneMessage] [nvarchar](max) NULL default NULL, -- ���D(�i����)
			[ReplyParent][char](36) NULL default NULL, -- GUID
			[DateCreate] [datetime] NOT NULL default CURRENT_TIMESTAMP,	-- �إ߸�Ʈɶ�
			[DateModify] [datetime] NOT NULL default CURRENT_TIMESTAMP  -- ��s��Ʈɶ�


		) 
	END;
    GO
	