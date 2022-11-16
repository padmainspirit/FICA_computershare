go
delete from CustomerUsers where Id = '51d7fdfd-9673-4e85-9484-621c5cf032f4';
go
delete from model_has_roles where model_id = '51d7fdfd-9673-4e85-9484-621c5cf032f4';
GO
INSERT [dbo].[CustomerUsers] ([Id], [FirstName], [LastName], [Title], [IDNumber], [Email], [Password], [IsAdmin], [Status], [CustomerId], [Code], [SubscriptionId], [PhoneNumber], [Message], [CreatedDate], [CreatedBy], [ModifiedDate], [ModifiedBy], [ActivatedBy], [ActivatedDate], [LastLoginDate], [BatchwithoutSub], [IsUserLoggedIn], [LeadswithoutSub], [MAchAddressCHK], [MacAddresses], [IsRestricted], [LastPasswordResetDate], [OTP_Date], [OTP]) 
VALUES (N'51d7fdfd-9673-4e85-9484-621c5cf032f4', N'Admin', N'User', N'Mr', N'9999999999999', N'superadmin@inspirit.co.za', N'$2y$10$CPC1iDgf/kUbf8XW/Xfciu4sMEA/C3EOOepJL2974YQz1yOQMr2He', 1, N'1', N'47b97c4a-e9f6-4283-bdb5-d500ca8851c1', NULL, NULL, N'8147455555', NULL, CAST(N'2022-10-11T07:30:29.2700000' AS DateTime2), NULL, CAST(N'2022-10-11T07:30:29.2700000' AS DateTime2), NULL, NULL, CAST(N'2022-10-11T07:30:29.2700000' AS DateTime2), NULL, NULL, NULL, NULL, NULL, NULL, 0, CAST(N'2022-10-11T07:30:29.270' AS DateTime), NULL, NULL)
GO
INSERT [dbo].[model_has_roles] ([role_id], [model_type], [model_id]) VALUES (1, N'App\Models\CustomerUser', N'51d7fdfd-9673-4e85-9484-621c5cf032f4')
GO
