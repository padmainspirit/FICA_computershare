USE [IDAS_FICASA]
GO

/****** Object:  Table [dbo].[SelfBankingExceptions]    Script Date: 25-07-2024 12:01:54 ******/
IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SelfBankingExceptions]') AND type in (N'U'))
DROP TABLE [dbo].[SelfBankingExceptions]
GO

/****** Object:  Table [dbo].[SelfBankingExceptions]    Script Date: 25-07-2024 12:01:54 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE TABLE [dbo].[SelfBankingExceptions](
	[Id] [uniqueidentifier] NULL,
	[SelfBankingLinkId] [uniqueidentifier] NULL,
	[API] [int] NULL,
	[Status] [varchar](250) NULL,
	[Comment] [varchar](max) NULL,
	[CreatedAt] [datetime] NULL
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO


