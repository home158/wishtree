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
			[WishReviewStatus] [char] NOT NULL default 0, -- 0:���ݼf�� 1: �f�֤��q�L 2: �f�ֳq�L
			[WishReviewDate] [datetime]  NULL , -- �f�֮ɶ�
			[WishReviewRejectReason] [nvarchar](30) NULL , --�@��f�֥��q�L��]

			
			[DeleteStatus] [bit] NOT NULL default 0, -- �R�����O 0:�D�R�� 1:�R��
			[DeleteDate]  [datetime] NULL, --�R�����O�ɶ�

			[MothballStatus] [bit] NOT NULL default 0, -- �ʦs���O 0:�D�ʦs 1:�ʦs
			[MothballDate]  [datetime] NULL, --�ʦs���O�ɶ�
			[DateExpire] [datetime] NOT NULL default CURRENT_TIMESTAMP,	-- ��ƹL���ɶ�
			[DateCreate] [datetime] NOT NULL default CURRENT_TIMESTAMP,	-- �إ߸�Ʈɶ�
			[DateModify] [datetime] NOT NULL default CURRENT_TIMESTAMP  -- ��s��Ʈɶ�


		) 
	END;
    GO
	