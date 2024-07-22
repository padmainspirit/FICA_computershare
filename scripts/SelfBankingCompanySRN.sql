USE [IDAS_FICASA]
GO

/****** Object:  Table [dbo].[TBL_Consumer_SelfBankingCompanySRN]    Script Date: 19-07-2024 18:23:05 ******/
IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[TBL_Consumer_SelfBankingCompanySRN]') AND type in (N'U'))
DROP TABLE [dbo].[TBL_Consumer_SelfBankingCompanySRN]
GO

/****** Object:  Table [dbo].[TBL_Consumer_SelfBankingCompanySRN]    Script Date: 19-07-2024 18:23:05 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE TABLE [dbo].[TBL_Consumer_SelfBankingCompanySRN](
	[Id] [uniqueidentifier] NULL,
	[SelfBankingDetailsId] [uniqueidentifier] NULL,
	[SRN] [varchar](50) NULL,
	[companies] [varchar](max) NULL,
	[createdAt] [datetime] NULL
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO


