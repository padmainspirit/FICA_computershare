USE IDAS_FICASA_ADMIN
GO

/****** Object:  Table [dbo].[Companies]    Script Date: 2024/07/05 12:30:02 ******/
IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[Companies]') AND type in (N'U'))
DROP TABLE [dbo].[Companies]
GO

/****** Object:  Table [dbo].[Companies]    Script Date: 2024/07/05 12:30:02 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE TABLE [dbo].[Companies](
	[Id] [uniqueidentifier] NOT NULL,
	[Company_Name] [varchar](100) NULL,
	[Created_At] [datetime2](7) NULL,
	[Updated_At] [datetime2](7) NULL
) ON [PRIMARY]
GO


