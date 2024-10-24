USE [IDAS_FICASA]
GO
/****** Object:  StoredProcedure [dbo].[sp_ConsumerSearch]    Script Date: 5/24/2023 3:12:55 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Name
-- Create date: 
-- Description:	
-- =============================================
ALTER PROCEDURE [dbo].[sp_ConsumerSearch] (  @customerid varchar(100), 
												@IDNUMBER varchar(50),
												@SURNAME varchar(200),
												@FIRSTNAME varchar(200),
												@CONTACTNO varchar(200),
												@FICASTATUS varchar(200),
												@FICARISKSTATUS varchar(50) = null)

AS
BEGIN
	 	 
		SELECT distinct TOP 300 c.consumerid, c.FirstName, c.SecondName, c.Surname, c.TitleCode,c.IDNUMBER,	c.[PhoneNumber], c.[Email], [ClientUniqueRef], f.[FICAStatus], f.[Risk_Status], f.[CreatedOnDate], f.[LastUpdatedDate]
		from [dbo].[TBL_Consumer] c
		join [IDAS_FICASA_ADMIN].[dbo].[Customers] cust on (cust.id = @customerid
		and  cust.id = c.Customerid)
		join [IDAS_FICASA_ADMIN].[dbo].[CustomerUsers] cu on (cu.CustomerId = @customerid)
		join [dbo].[TBL_FICA] f 
			on (c.Consumerid = f.Consumerid 
			and f.FICAStatus = ISNULL(@FICASTATUS, f.FICAStatus)
			and (f.Risk_Status = @FICARISKSTATUS
			or ISNULL(@FICARISKSTATUS, '') = '')
			)
		join [TBL_Consumer_Telephones] ct on (c.consumerID = ct.consumerID
			and ct.recordstatusind = 1
			and c.[PhoneNumber] = ISNULL(@CONTACTNO, c.PhoneNumber) )
		where c.[IDNUMBER] = ISNULL(@IDNUMBER, c.IDNUMBER)
		and c.[FirstName] LIKE '%' +  ISNULL(@FIRSTNAME, c.FirstName) + '%'
		and c.[surname] LIKE '%' +   ISNULL(@SURNAME, c.surname) + '%'
		and cu.IsAdmin = 0
		order by c.Consumerid asc
	
end










--USE [IDAS_FICASA]
--GO
--/****** Object:  StoredProcedure [dbo].[sp_ConsumerSearch]    Script Date: 5/19/2023 5:58:41 PM ******/
--SET ANSI_NULLS ON
--GO
--SET QUOTED_IDENTIFIER ON
--GO

----Author Mischa Naidoo

--ALTER PROCedure [dbo].[sp_ConsumerSearch] (@customerid varchar(100), 
--											@SearchType int, 
--											@IDNUMBER varchar(50) = Null, 
--											@SURNAME varchar(200) = Null,  
--											@FIRSTNAME varchar(200) = Null, 
--											@CONTACTNO varchar(200) = Null,
--											@FICASTATUS  varchar(200) = Null, 
--											@CLIENTREF varchar(200) = Null)
--AS  
--BEGIN


----Search Types
---- 1 = Identity Number
----2 = Surname 
----3 = FIRSTNAME
----4 = SURNAME AN FIRSTNAME
----5 = CONTACTNO
----6 = FICASTATUS
----7 = CLIENTREF


---- "1=ID Number":  [sp_ConsumerSearch] '4717E73D-1F3F-4ACE-BE1A-0244770D6272', 1, '7711025013082'
---- "2=SURNAME":  [sp_ConsumerSearch] '4717E73D-1F3F-4ACE-BE1A-0244770D6272', 2, '', 'naidoo'
---- "3=Firstname":  [sp_ConsumerSearch] '4717E73D-1F3F-4ACE-BE1A-0244770D6272', 3, '', '', 'mlungisi'
---- "4=Surname and Firstname":  [sp_ConsumerSearch] '4717E73D-1F3F-4ACE-BE1A-0244770D6272', 4, '', 'Nzimande', 'mlungisi'
---- "5=Contact Number":  [sp_ConsumerSearch] '4717E73D-1F3F-4ACE-BE1A-0244770D6272', 5, '', '', '', '0823737777'
---- "6=Contact Number":  [sp_ConsumerSearch] '4717E73D-1F3F-4ACE-BE1A-0244770D6272', 6, '', '', '', '', 'In Progress'



--if   @SearchType = 1
--	 begin
--		SELECT distinct c.consumerid, c.FirstName, c.SecondName, c.Surname, c.TitleCode,c.IDNUMBER,	c.[Email], [ClientUniqueRef], f.[FICAStatus], f.[LastUpdatedDate]
--		from [dbo].[TBL_Consumer] c
--		join [IDAS_FICASA_ADMIN].[dbo].[Customers] cust on (cust.id = @customerid
--		and  cust.id = c.Customerid)
--		join [IDAS_FICASA_ADMIN].[dbo].[CustomerUsers] cu on (cu.CustomerId = @customerid)
--		left join [dbo].[TBL_FICA] f on (c.Consumerid = f.Consumerid)
--		where c.[IDNUMBER] = @IDNUMBER
--		and cu.IsAdmin = 0
--	end
	
--if	@SearchType = 2
--	begin
--		SELECT distinct c.consumerid, c.FirstName, c.SecondName, c.Surname, c.TitleCode,c.IDNUMBER,	c.[Email], [ClientUniqueRef], f.[FICAStatus], f.[LastUpdatedDate]
--		from [dbo].[TBL_Consumer] c
--		join [IDAS_FICASA_ADMIN].[dbo].[Customers] cust on (cust.id = @customerid
--		and  cust.id = c.Customerid)
--		join [IDAS_FICASA_ADMIN].[dbo].[CustomerUsers] cu on (cu.CustomerId = @customerid)
--		left join [dbo].[TBL_FICA] f on (c.Consumerid = f.Consumerid)
--		where c.[surname] = @SURNAME
--		and cu.IsAdmin = 0

--	end;

--if	@SearchType = 3
--	begin
--		SELECT distinct c.consumerid, c.FirstName, c.SecondName, c.Surname, c.TitleCode,c.IDNUMBER,	c.[Email], [ClientUniqueRef], f.[FICAStatus], f.[LastUpdatedDate]
--		from [dbo].[TBL_Consumer] c
--		join [IDAS_FICASA_ADMIN].[dbo].[Customers] cust on (cust.id = @customerid
--		and  cust.id = c.Customerid)
--		join [IDAS_FICASA_ADMIN].[dbo].[CustomerUsers] cu on (cu.CustomerId = @customerid)
--		left join [dbo].[TBL_FICA] f on (c.Consumerid = f.Consumerid)
--		where c.[FirstName] = @FIRSTNAME
--		and cu.IsAdmin = 0

--	end;

--if	@SearchType = 4
--	begin
--		SELECT distinct c.consumerid, c.FirstName, c.SecondName, c.Surname, c.TitleCode,c.IDNUMBER,	c.[Email], [ClientUniqueRef], f.[FICAStatus], f.[LastUpdatedDate]
--		from [dbo].[TBL_Consumer] c
--		join [IDAS_FICASA_ADMIN].[dbo].[Customers] cust on (cust.id = @customerid
--		and  cust.id = c.Customerid)
--		left join [dbo].[TBL_FICA] f on (c.Consumerid = f.Consumerid)
--	    join [IDAS_FICASA_ADMIN].[dbo].[CustomerUsers] cu on (cu.CustomerId = @customerid)
--		where c.[surname] = @SURNAME
--		and c.[FirstName] = @FIRSTNAME
--		and cu.IsAdmin = 0

--	end;


--	if	@SearchType = 5
--	begin


--	 set CONCAT_NULL_YIELDS_NULL off

--		SELECT distinct c.consumerid, c.FirstName, c.SecondName, c.Surname, c.TitleCode,c.IDNUMBER, c.[PhoneNumber],c.[Email], [ClientUniqueRef], f.[FICAStatus], f.[LastUpdatedDate]
--		from [dbo].[TBL_Consumer] c
--		join [IDAS_FICASA_ADMIN].[dbo].[Customers] cust on (cust.id = @customerid
--		and  cust.id = c.Customerid)
--		join [IDAS_FICASA_ADMIN].[dbo].[CustomerUsers] cu on (cu.CustomerId = @customerid)
--		left join [dbo].[TBL_FICA] f on (c.Consumerid = f.Consumerid)
--		join [TBL_Consumer_Telephones] ct on (c.consumerID = ct.consumerID
--		and ct.recordstatusind = 1
--		and c.[PhoneNumber] = @CONTACTNO )
--	    and cu.IsAdmin = 0

--	set CONCAT_NULL_YIELDS_NULL on

--	end;


--	if	@SearchType = 6
--	begin


--		SELECT distinct c.consumerid, c.FirstName, c.SecondName, c.Surname, c.TitleCode,c.IDNUMBER,	c.[Email], [ClientUniqueRef], f.[FICAStatus], f.[LastUpdatedDate]
--		from [dbo].[TBL_FICA] f 
--		join [dbo].[TBL_Consumer] c on (f.Consumerid = c.Consumerid
--		and [FICAStatus] = @FICASTATUS) 
--		join [IDAS_FICASA_ADMIN].[dbo].[CustomerUsers] cu on (cu.CustomerId = @customerid)
--		 join [IDAS_FICASA_ADMIN].[dbo].[Customers] cust on (cust.id = @customerid
--		and  cust.id = c.Customerid)
--		and cu.IsAdmin = 0

--	end;


--	if	@SearchType = 7
--	begin


--		SELECT distinct c.consumerid, c.FirstName, c.SecondName, c.Surname, c.TitleCode,c.IDNUMBER,	c.Email, c.ClientUniqueRef, f.FICAStatus, f.LastUpdatedDate
--		from [dbo].[TBL_FICA] f 
--		join [IDAS_FICASA_ADMIN].[dbo].[Customers] cust on (cust.id = @customerid)
--		join [IDAS_FICASA_ADMIN].[dbo].[CustomerUsers] cu on (cu.CustomerId = @customerid)
--		join [dbo].[TBL_Consumer] c on (c.Consumerid = f.Consumerid 
--		and  cust.id = c.Customerid)
--		and c.ClientUniqueRef = @CLIENTREF
--		and cu.IsAdmin = 0

--	end;

----SELECT c.consumerid, c.FirstName, c.SecondName, c.Surname, c.TitleCode, c.Email, c.GenderInd, c.IDNUMBER,[Employmentstatus],[Nameofemployer],[NOYearsAtEmployer],[Employmenttype], 
----c.BirthDate, c.Married_under, c.Marriage_date 
----from [dbo].[TBL_Consumer] c
----where c.consumerid = @ConsumerID 

---------Contact Details

----select c.*, ld.text, [TelephoneTypeInd], c.[ConsumerID],[TelephoneCode], [TelephoneNo], ct.[CreatedonDate], [ChangedonDate], ct.[LastUpdatedDate]
------HOME_1_PHONE_NUMBER as 'TelephoneHome', WORK_1_PHONE_NUMBER as 'TelephoneWork', CELL_1_PHONE_NUMBER as 'MobileNumber'[ReFICADate]
----from [dbo].[TBL_Consumer_Telephones] ct
---- join TBL_Consumer c on (c.consumerID = ct.consumerID)
---- join [IDAS_FICASA_ADMIN].[dbo].[LookupDatas] LD on (LD.value = ct.TelephoneTypeInd
---- and LD.type = 'Telephone Type Indicator')
---- and RecordStatusInd =1 
---- order by [TelephoneTypeInd] asc

--------Employment Details

----select c.Employmentstatus, c.Nameofemployer, ca.OriginalAddress1, ca.OriginalPostalCode, c.Industryofoccupation,
----c.NOYearsAtEmployer,c.Employmenttype 
----into #consumer 
----from [dbo].[TBL_Consumer] c 
----	join [dbo].[TBL_Consumer_Addresses] ca on (c.Consumerid = ca.ConsumerID and AddressTypeInd = 1)

----select * from #consumer

--------Addresses
----select ci.HOME_ADDRESS1_LINE_1, ci.HOME_ADDRESS1_LINE_2, ca.Province, ca.OriginalPostalCode, ci.ID_CountryResidence 
----into #addresses from [dbo].[TBL_Consumer] c
----	join [dbo].[TBL_Consumer_Addresses] ca on (@ConsumerID = ca.ConsumerID
----												and recordstatusind = 1)
----	Join [dbo].[TBL_Consumer_IDENTITY] ci on (@ConsumerID = c.consumerid)

----select * from #addresses

-------Financials

----SELECT * into #AccountTypes from [dbo].[Ref_Bank_Account_Types]

----select avs.Bank_name ,(select AccountType from #AccountTypes) as 'Account Type', avs.Branch, avs.Branch_code,
----avs.Account_no, ci.SURNAME as 'Account Holder Surname', ci.INITIALS as 'Account Holder'
----from [dbo].[TBL_Consumer_AVS] avs 
----	join [dbo].[TBL_Consumer_IDENTITY] ci on (ci.FICA_id = avs.FICA_id)

 

--END

