USE [IDAS_FICASA]
GO

ALTER TABLE [dbo].[TBL_Consumer_SelfBankingDetails] DROP CONSTRAINT [DF_TBL_Consumer_CompLite_debt_summary]
GO

ALTER TABLE [dbo].[TBL_Consumer_SelfBankingDetails] DROP CONSTRAINT [DF_TBL_Consumer_SelfBankingDetails_Risk]
GO

ALTER TABLE [dbo].[TBL_Consumer_SelfBankingDetails] DROP CONSTRAINT [DF_TBL_Consumer_SelfBankingDetails_Compliance]
GO

ALTER TABLE [dbo].[TBL_Consumer_SelfBankingDetails] DROP CONSTRAINT [DF_TBL_Consumer_SelfBankingDetails_DOVS]
GO

ALTER TABLE [dbo].[TBL_Consumer_SelfBankingDetails] DROP CONSTRAINT [DF_TBL_Consumer_SelfBankingDetails_AVS]
GO

ALTER TABLE [dbo].[TBL_Consumer_SelfBankingDetails] DROP CONSTRAINT [DF_TBL_Consumer_SelfBankingDetails_KYC]
GO

ALTER TABLE [dbo].[TBL_Consumer_SelfBankingDetails] DROP CONSTRAINT [DF_TBL_Consumer_SelfBankingDetails_IDV]
GO

/****** Object:  Table [dbo].[TBL_Consumer_SelfBankingDetails]    Script Date: 16-07-2024 11:42:40 ******/
IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[TBL_Consumer_SelfBankingDetails]') AND type in (N'U'))
DROP TABLE [dbo].[TBL_Consumer_SelfBankingDetails]
GO

/****** Object:  Table [dbo].[TBL_Consumer_SelfBankingDetails]    Script Date: 16-07-2024 11:42:40 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE TABLE [dbo].[TBL_Consumer_SelfBankingDetails](
	[SelfBankingDetailsId] [uniqueidentifier] NOT NULL,
	[SelfBankingLinkId] [uniqueidentifier] NOT NULL,
	[Customerid] [varchar](50) NULL,
	[IDNUMBER] [varchar](255) NULL,
	[FirstName] [varchar](100) NULL,
	[SecondName] [varchar](100) NULL,
	[ThirdName] [varchar](100) NULL,
	[Surname] [varchar](100) NULL,
	[BirthDate] [datetime] NULL,
	[TitleCode] [varchar](10) NULL,
	[CreatedOnDate] [datetime] NULL,
	[LastUpdatedDate] [datetime] NULL,
	[Email] [varchar](100) NULL,
	[PhoneNumber] [nchar](10) NULL,
	[PhoneNumberHome] [nchar](10) NULL,
	[PhoneNumberWork] [nchar](10) NULL,
	[Address_Line1] [nvarchar](100) NULL,
	[Address_Line2] [nvarchar](200) NULL,
	[City] [nvarchar](100) NULL,
	[Province] [nvarchar](100) NULL,
	[zip] [nvarchar](20) NULL,
	[Marital_status] [varchar](50) NULL,
	[Marriage_date] [varchar](50) NULL,
	[AccountType] [varchar](50) NULL,
	[AccountHolderInitial] [nchar](10) NULL,
	[BankName] [varchar](50) NULL,
	[AccountNumber] [varchar](50) NULL,
	[IDV] [int] NULL,
	[KYC] [int] NULL,
	[AVS] [int] NULL,
	[DOVS] [int] NULL,
	[Compliance] [int] NULL,
	[Risk] [int] NULL,
	[debt_summary] [int] NULL,
	[Client_Ref] [varchar](150) NULL
) ON [PRIMARY]
GO

ALTER TABLE [dbo].[TBL_Consumer_SelfBankingDetails] ADD  CONSTRAINT [DF_TBL_Consumer_SelfBankingDetails_IDV]  DEFAULT ((0)) FOR [IDV]
GO

ALTER TABLE [dbo].[TBL_Consumer_SelfBankingDetails] ADD  CONSTRAINT [DF_TBL_Consumer_SelfBankingDetails_KYC]  DEFAULT ((0)) FOR [KYC]
GO

ALTER TABLE [dbo].[TBL_Consumer_SelfBankingDetails] ADD  CONSTRAINT [DF_TBL_Consumer_SelfBankingDetails_AVS]  DEFAULT ((0)) FOR [AVS]
GO

ALTER TABLE [dbo].[TBL_Consumer_SelfBankingDetails] ADD  CONSTRAINT [DF_TBL_Consumer_SelfBankingDetails_DOVS]  DEFAULT ((0)) FOR [DOVS]
GO

ALTER TABLE [dbo].[TBL_Consumer_SelfBankingDetails] ADD  CONSTRAINT [DF_TBL_Consumer_SelfBankingDetails_Compliance]  DEFAULT ((0)) FOR [Compliance]
GO

ALTER TABLE [dbo].[TBL_Consumer_SelfBankingDetails] ADD  CONSTRAINT [DF_TBL_Consumer_SelfBankingDetails_Risk]  DEFAULT ((0)) FOR [Risk]
GO

ALTER TABLE [dbo].[TBL_Consumer_SelfBankingDetails] ADD  CONSTRAINT [DF_TBL_Consumer_CompLite_debt_summary]  DEFAULT ((0)) FOR [debt_summary]
GO


