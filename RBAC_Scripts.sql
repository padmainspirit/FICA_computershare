USE [IDAS_FICASA_ADMIN]
GO
ALTER TABLE [dbo].[role_has_permissions] DROP CONSTRAINT [role_has_permissions_role_id_foreign]
GO
ALTER TABLE [dbo].[role_has_permissions] DROP CONSTRAINT [role_has_permissions_permission_id_foreign]
GO
ALTER TABLE [dbo].[model_has_roles] DROP CONSTRAINT [model_has_roles_role_id_foreign]
GO
ALTER TABLE [dbo].[model_has_permissions] DROP CONSTRAINT [model_has_permissions_permission_id_foreign]
GO
/****** Object:  Index [roles_name_guard_name_unique]    Script Date: 11-11-2022 10:49:15 ******/
DROP INDEX [roles_name_guard_name_unique] ON [dbo].[roles]
GO
/****** Object:  Index [permissions_name_guard_name_unique]    Script Date: 11-11-2022 10:49:15 ******/
DROP INDEX [permissions_name_guard_name_unique] ON [dbo].[permissions]
GO
/****** Object:  Table [dbo].[roles]    Script Date: 11-11-2022 10:49:15 ******/
IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[roles]') AND type in (N'U'))
DROP TABLE [dbo].[roles]
GO
/****** Object:  Table [dbo].[role_has_permissions]    Script Date: 11-11-2022 10:49:15 ******/
IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[role_has_permissions]') AND type in (N'U'))
DROP TABLE [dbo].[role_has_permissions]
GO
/****** Object:  Table [dbo].[permissions]    Script Date: 11-11-2022 10:49:15 ******/
IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[permissions]') AND type in (N'U'))
DROP TABLE [dbo].[permissions]
GO
/****** Object:  Table [dbo].[model_has_roles]    Script Date: 11-11-2022 10:49:15 ******/
IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[model_has_roles]') AND type in (N'U'))
DROP TABLE [dbo].[model_has_roles]
GO
/****** Object:  Table [dbo].[model_has_permissions]    Script Date: 11-11-2022 10:49:15 ******/
IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[model_has_permissions]') AND type in (N'U'))
DROP TABLE [dbo].[model_has_permissions]
GO
/****** Object:  Table [dbo].[model_has_permissions]    Script Date: 11-11-2022 10:49:15 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[model_has_permissions](
	[permission_id] [bigint] NOT NULL,
	[model_type] [nvarchar](255) NOT NULL,
	[model_id] [nvarchar](max) NOT NULL
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[model_has_roles]    Script Date: 11-11-2022 10:49:16 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[model_has_roles](
	[role_id] [bigint] NOT NULL,
	[model_type] [nvarchar](255) NOT NULL,
	[model_id] [uniqueidentifier] NOT NULL,
 CONSTRAINT [PK_model_has_roles] PRIMARY KEY CLUSTERED 
(
	[role_id] ASC,
	[model_type] ASC,
	[model_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[permissions]    Script Date: 11-11-2022 10:49:16 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[permissions](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[name] [nvarchar](255) NOT NULL,
	[guard_name] [nvarchar](255) NOT NULL,
	[created_at] [datetime] NULL,
	[updated_at] [datetime] NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[role_has_permissions]    Script Date: 11-11-2022 10:49:16 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[role_has_permissions](
	[permission_id] [bigint] NOT NULL,
	[role_id] [bigint] NOT NULL,
 CONSTRAINT [role_has_permissions_permission_id_role_id_primary] PRIMARY KEY CLUSTERED 
(
	[permission_id] ASC,
	[role_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[roles]    Script Date: 11-11-2022 10:49:16 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[roles](
	[id] [bigint] IDENTITY(1,1) NOT NULL,
	[name] [nvarchar](255) NOT NULL,
	[guard_name] [nvarchar](255) NOT NULL,
	[created_at] [datetime] NULL,
	[updated_at] [datetime] NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
INSERT [dbo].[model_has_roles] ([role_id], [model_type], [model_id]) VALUES (1, N'App\Models\CustomerUser', N'97afec47-6cd7-470e-a65e-0efeb89eba4f')
GO
INSERT [dbo].[model_has_roles] ([role_id], [model_type], [model_id]) VALUES (1, N'App\Models\CustomerUser', N'cb87d7b5-da48-4858-857d-aeab4e3d1058')
GO
INSERT [dbo].[model_has_roles] ([role_id], [model_type], [model_id]) VALUES (2, N'App\Models\CustomerUser', N'97b17606-d7e0-43cd-bddc-1276ba79d668')
GO
INSERT [dbo].[model_has_roles] ([role_id], [model_type], [model_id]) VALUES (2, N'App\Models\CustomerUser', N'97b180e8-f8b9-4f8a-9ecc-1e60c9444ed5')
GO
INSERT [dbo].[model_has_roles] ([role_id], [model_type], [model_id]) VALUES (2, N'App\Models\CustomerUser', N'97b17469-2c14-47ad-b60c-9d78fdd23377')
GO
INSERT [dbo].[model_has_roles] ([role_id], [model_type], [model_id]) VALUES (2, N'App\Models\CustomerUser', N'97aa7864-058d-42b9-bd3a-d2e9c969299b')
GO
INSERT [dbo].[model_has_roles] ([role_id], [model_type], [model_id]) VALUES (2, N'App\Models\CustomerUser', N'2aaa3fa3-ee99-4d8f-923f-df8bc0ef54f3')
GO
INSERT [dbo].[model_has_roles] ([role_id], [model_type], [model_id]) VALUES (3, N'App\Models\CustomerUser', N'97b4126b-a4ea-4937-84eb-8a150aa3ab3b')
GO
SET IDENTITY_INSERT [dbo].[permissions] ON 
GO
INSERT [dbo].[permissions] ([id], [name], [guard_name], [created_at], [updated_at]) VALUES (1, N'user-list', N'web', CAST(N'2022-11-03T12:14:25.963' AS DateTime), CAST(N'2022-11-03T12:14:25.963' AS DateTime))
GO
INSERT [dbo].[permissions] ([id], [name], [guard_name], [created_at], [updated_at]) VALUES (2, N'user-create', N'web', CAST(N'2022-11-03T12:14:26.130' AS DateTime), CAST(N'2022-11-03T12:14:26.130' AS DateTime))
GO
INSERT [dbo].[permissions] ([id], [name], [guard_name], [created_at], [updated_at]) VALUES (3, N'user-edit', N'web', CAST(N'2022-11-03T12:14:26.157' AS DateTime), CAST(N'2022-11-03T12:14:26.157' AS DateTime))
GO
INSERT [dbo].[permissions] ([id], [name], [guard_name], [created_at], [updated_at]) VALUES (4, N'user-delete', N'web', CAST(N'2022-11-03T12:14:26.187' AS DateTime), CAST(N'2022-11-03T12:14:26.187' AS DateTime))
GO
INSERT [dbo].[permissions] ([id], [name], [guard_name], [created_at], [updated_at]) VALUES (5, N'admin-dashboard', N'web', CAST(N'2022-11-03T12:14:26.213' AS DateTime), CAST(N'2022-11-03T12:14:26.213' AS DateTime))
GO
INSERT [dbo].[permissions] ([id], [name], [guard_name], [created_at], [updated_at]) VALUES (6, N'admin-seach-user', N'web', CAST(N'2022-11-03T12:14:26.237' AS DateTime), CAST(N'2022-11-03T12:14:26.237' AS DateTime))
GO
INSERT [dbo].[permissions] ([id], [name], [guard_name], [created_at], [updated_at]) VALUES (7, N'todo-edit', N'web', CAST(N'2022-11-03T12:14:26.260' AS DateTime), CAST(N'2022-11-03T12:14:26.260' AS DateTime))
GO
INSERT [dbo].[permissions] ([id], [name], [guard_name], [created_at], [updated_at]) VALUES (8, N'todo-delete', N'web', CAST(N'2022-11-03T12:14:26.283' AS DateTime), CAST(N'2022-11-03T12:14:26.283' AS DateTime))
GO
SET IDENTITY_INSERT [dbo].[permissions] OFF
GO
INSERT [dbo].[role_has_permissions] ([permission_id], [role_id]) VALUES (1, 1)
GO
INSERT [dbo].[role_has_permissions] ([permission_id], [role_id]) VALUES (1, 2)
GO
INSERT [dbo].[role_has_permissions] ([permission_id], [role_id]) VALUES (1, 3)
GO
INSERT [dbo].[role_has_permissions] ([permission_id], [role_id]) VALUES (2, 1)
GO
INSERT [dbo].[role_has_permissions] ([permission_id], [role_id]) VALUES (3, 1)
GO
INSERT [dbo].[role_has_permissions] ([permission_id], [role_id]) VALUES (4, 1)
GO
INSERT [dbo].[role_has_permissions] ([permission_id], [role_id]) VALUES (5, 1)
GO
INSERT [dbo].[role_has_permissions] ([permission_id], [role_id]) VALUES (5, 2)
GO
INSERT [dbo].[role_has_permissions] ([permission_id], [role_id]) VALUES (6, 1)
GO
INSERT [dbo].[role_has_permissions] ([permission_id], [role_id]) VALUES (7, 1)
GO
INSERT [dbo].[role_has_permissions] ([permission_id], [role_id]) VALUES (7, 2)
GO
INSERT [dbo].[role_has_permissions] ([permission_id], [role_id]) VALUES (8, 1)
GO
INSERT [dbo].[role_has_permissions] ([permission_id], [role_id]) VALUES (8, 2)
GO
SET IDENTITY_INSERT [dbo].[roles] ON 
GO
INSERT [dbo].[roles] ([id], [name], [guard_name], [created_at], [updated_at]) VALUES (1, N'SuperAdmin', N'web', CAST(N'2022-11-03T12:15:18.020' AS DateTime), CAST(N'2022-11-09T12:11:53.900' AS DateTime))
GO
INSERT [dbo].[roles] ([id], [name], [guard_name], [created_at], [updated_at]) VALUES (2, N'CustomerAdmin', N'web', CAST(N'2022-11-08T04:58:47.550' AS DateTime), CAST(N'2022-11-09T12:19:03.437' AS DateTime))
GO
INSERT [dbo].[roles] ([id], [name], [guard_name], [created_at], [updated_at]) VALUES (3, N'CustomerUser', N'web', CAST(N'2022-11-09T12:13:20.243' AS DateTime), CAST(N'2022-11-09T12:19:10.823' AS DateTime))
GO
SET IDENTITY_INSERT [dbo].[roles] OFF
GO
SET ANSI_PADDING ON
GO
/****** Object:  Index [permissions_name_guard_name_unique]    Script Date: 11-11-2022 10:49:16 ******/
CREATE UNIQUE NONCLUSTERED INDEX [permissions_name_guard_name_unique] ON [dbo].[permissions]
(
	[name] ASC,
	[guard_name] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
GO
SET ANSI_PADDING ON
GO
/****** Object:  Index [roles_name_guard_name_unique]    Script Date: 11-11-2022 10:49:16 ******/
CREATE UNIQUE NONCLUSTERED INDEX [roles_name_guard_name_unique] ON [dbo].[roles]
(
	[name] ASC,
	[guard_name] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
GO
ALTER TABLE [dbo].[model_has_permissions]  WITH CHECK ADD  CONSTRAINT [model_has_permissions_permission_id_foreign] FOREIGN KEY([permission_id])
REFERENCES [dbo].[permissions] ([id])
ON DELETE CASCADE
GO
ALTER TABLE [dbo].[model_has_permissions] CHECK CONSTRAINT [model_has_permissions_permission_id_foreign]
GO
ALTER TABLE [dbo].[model_has_roles]  WITH CHECK ADD  CONSTRAINT [model_has_roles_role_id_foreign] FOREIGN KEY([role_id])
REFERENCES [dbo].[roles] ([id])
ON DELETE CASCADE
GO
ALTER TABLE [dbo].[model_has_roles] CHECK CONSTRAINT [model_has_roles_role_id_foreign]
GO
ALTER TABLE [dbo].[role_has_permissions]  WITH CHECK ADD  CONSTRAINT [role_has_permissions_permission_id_foreign] FOREIGN KEY([permission_id])
REFERENCES [dbo].[permissions] ([id])
ON DELETE CASCADE
GO
ALTER TABLE [dbo].[role_has_permissions] CHECK CONSTRAINT [role_has_permissions_permission_id_foreign]
GO
ALTER TABLE [dbo].[role_has_permissions]  WITH CHECK ADD  CONSTRAINT [role_has_permissions_role_id_foreign] FOREIGN KEY([role_id])
REFERENCES [dbo].[roles] ([id])
ON DELETE CASCADE
GO
ALTER TABLE [dbo].[role_has_permissions] CHECK CONSTRAINT [role_has_permissions_role_id_foreign]
GO
