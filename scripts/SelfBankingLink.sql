USE [IDAS_FICASA_ADMIN]
GO

ALTER TABLE [dbo].[SelfBankingLink] DROP CONSTRAINT [DF_SelfBanking_tnc_flag]
GO

ALTER TABLE [dbo].[SelfBankingLink] DROP CONSTRAINT [DF_Table_1_is_clicked]
GO

ALTER TABLE [dbo].[SelfBankingLink] DROP CONSTRAINT [DF_Table_1_SMS]
GO

ALTER TABLE [dbo].[SelfBankingLink] DROP CONSTRAINT [DF_SelfBanking_Email]
GO

/****** Object:  Table [dbo].[SelfBankingLink]    Script Date: 12-07-2024 18:41:28 ******/
IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SelfBankingLink]') AND type in (N'U'))
DROP TABLE [dbo].[SelfBankingLink]
GO

/****** Object:  Table [dbo].[SelfBankingLink]    Script Date: 12-07-2024 18:41:28 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE TABLE [dbo].[SelfBankingLink](
	[Id] [uniqueidentifier] NULL,
	[CustomerUserId] [uniqueidentifier] NULL,
	[Email] [varchar](50) NULL,
	[PhoneNumber] [varchar](50) NULL,
	[LinkGenerated] [nvarchar](max) NULL,
	[CreatedAt] [datetime] NULL,
	[UpdatedAt] [datetime] NULL,
	[IsClicked] [tinyint] NULL,
	[CustomerId] [uniqueidentifier] NULL,
	[tnc_flag] [tinyint] NULL
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO

ALTER TABLE [dbo].[SelfBankingLink] ADD  CONSTRAINT [DF_SelfBanking_Email]  DEFAULT (NULL) FOR [Email]
GO

ALTER TABLE [dbo].[SelfBankingLink] ADD  CONSTRAINT [DF_Table_1_SMS]  DEFAULT (NULL) FOR [PhoneNumber]
GO

ALTER TABLE [dbo].[SelfBankingLink] ADD  CONSTRAINT [DF_Table_1_is_clicked]  DEFAULT ((0)) FOR [IsClicked]
GO

ALTER TABLE [dbo].[SelfBankingLink] ADD  CONSTRAINT [DF_SelfBanking_tnc_flag]  DEFAULT ((0)) FOR [tnc_flag]
GO


