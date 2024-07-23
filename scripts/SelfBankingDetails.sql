USE [IDAS_FICASA]
GO



/****** Object:  Table [dbo].[TBL_Consumer_SelfBankingDetails]    Script Date: 22-07-2024 12:00:23 ******/
IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[TBL_Consumer_SelfBankingDetails]') AND type in (N'U'))
DROP TABLE [dbo].[TBL_Consumer_SelfBankingDetails]
GO

/****** Object:  Table [dbo].[TBL_Consumer_SelfBankingDetails]    Script Date: 22-07-2024 12:00:23 ******/
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
	[AccountType] [varchar](50) NULL,
	[AccountHolderInitial] [nchar](10) NULL,
	[BankName] [varchar](50) NULL,
	[AccountNumber] [varchar](50) NULL,
	[Client_Ref] [varchar](150) NULL
) ON [PRIMARY]
GO

