--assign uniqueidentifier in a variable
DECLARE @GUID uniqueidentifier
SET @GUID = NEWID()

--Drop tables
-- Drop the i_fortune_message.
	IF EXISTS (SELECT * FROM sys.objects 
		WHERE object_id = OBJECT_ID(N'[dbo].[i_fortune_message]') 
		AND type in (N'U'))
	DROP TABLE [dbo].[i_fortune_message]

-- Drop the i_fortune.
	IF EXISTS (SELECT * FROM sys.objects 
		WHERE object_id = OBJECT_ID(N'[dbo].[i_fortune]') 
		AND type in (N'U'))
	DROP TABLE [dbo].[i_fortune]


-- Create the i_wish table.

	
	BEGIN
		CREATE TABLE [dbo].[i_fortune](
			[FortuneID] [int] IDENTITY(2987,1) NOT NULL,
			[GUID] [char](36) NOT NULL DEFAULT NEWID()  PRIMARY KEY, -- GUID
			[Services] [tinyint] NOT NULL default 0, --�A�ȶ��� 0 : ��y�~�A1:�שR
			[UserGUID] [char](36) NOT NULL  
					REFERENCES [dbo].[i_user](GUID)						
					ON DELETE CASCADE, 
			[Nickname] [nvarchar](128)  NULL,	-- �κ�
			[Role] [nvarchar](10) NOT NULL default 'female', -- �b������0:Girl , 1:Daddy

			[Birthday] [datetime] NOT NULL, -- �X�ͤ��
			[BornHour] [tinyint] NOT NULL, -- �X�ͮɨ�
			[Lunar] [nvarchar](50) NOT NULL, -- �X�ͤ��
			[Maritalstatus] [nvarchar](30) NULL default NULL, --�B�ê��A
			--[Request] [nvarchar](max) NULL default NULL, -- ���D(�i����)
			[PblmEmail] [nvarchar](255) NOT NULL , -- �p���� email,�s�̫�@�����
			[PblmTel] [nvarchar](255) NOT NULL , -- �p���覡,�s�̫�@�����
			[PaymentStatus] [tinyint] NOT NULL default 0, --�I�O���O 0 : ���ݥI�O�A1:���ݥI�O :�w�I�O�A
			[DatePayment] [datetime] NULL default NULL,	-- �I�O���O�ɶ�
			[NotifyPaymentStatus] [tinyint] NOT NULL default 0, --�q���I�O���O 0 : ���ݳq�� ; 1:�w�q���I�O
			[DateNotifyPayment] [datetime] NULL default NULL,	-- �q���I�O���O�ɶ�

			[FortuneStatus] [tinyint] NOT NULL default 0, --��R���O 0 : ���ݩw�L�A1 : �w�L�T�{�}�l���R 2:���R����
			[ST] [bit] NOT NULL default 0, --�������O 0 : �������A1:�v���� [PaymentStatus] = 0 AND [FortuneStatus] = 0 �~�i����
			[DateST] [datetime] NULL default NULL,	-- �������O�ɶ�
			[MT] [bit] NOT NULL default 0, --�f�����O 0 : ���f���A1:�v�f��
			[DateMT] [datetime] NULL default NULL,	-- �f�����O�ɶ�

			[TypeDiscussion] [tinyint] NOT NULL default 0, --�שR�覡 0 : �u�W�A1:�q�T�u��A2:���ﭱ
			[LocationDiscussion] [nvarchar](256) NULL default NULL, --�w�w�שR�a�I
			[DateDiscussion] [datetime] NULL default NULL,	-- �w�w�שR���
			[DateCreate] [datetime] NOT NULL default CURRENT_TIMESTAMP,	-- �إ߸�Ʈɶ�
			[DateModify] [datetime] NOT NULL default CURRENT_TIMESTAMP  -- ��s��Ʈɶ�


		) 
	END;
    GO
	