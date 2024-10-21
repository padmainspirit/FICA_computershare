USE [IDAS_FICASA]
GO
/****** Object:  StoredProcedure [dbo].[SP_selfbankingresults_All]    Script Date: 15-10-2024 12:00:26 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
Create PROCEDURE [dbo].[SP_selfbankingresults_All]  @CreatedOnDate Date,  @SBIds varchar(max)
AS
BEGIN
SET NOCOUNT ON;

--exec [SP_Complianceresults] 'FB49A80D-AFA1-4A27-876E-0349D6A14C20'

--Create NonClustered Index #consumerid on #consumer_tracing(consumerid)
--Create NonClustered Index #IDNUMBERS_ConsumerId on  #consumer_tracing(IDNUMBER)

--Extract Consumer Data into Temp Table
--declare @list varchar(max) 
--'4717E73D-1F3F-4ACE-BE1A-0244770D6272,47B97C4A-E9F6-4283-BDB5-D500CA8851C1,6CC9CF5F-86D9-4E30-B584-A390BC99B104'
select con.*, f.Validation_Status
into #Consumer
from [dbo].[TBL_Consumer_SelfBankingDetails] con
left join TBL_FICA f on (f.Consumerid = con.SelfBankingDetailsId)
		--left join [INSPIRIT_FICA_ADMIN].dbo.LookupDatas ld on ld.Type = 'Gender Type Indicator'
			--left join [INSPIRIT_FICA_ADMIN].dbo.LookupDatas Td on (Td.value = con.TitleCode COLLATE Latin1_General_CI_AS
			--and Td.Type = 'Title Code Indicator')
			
			
where con.CreatedOnDate between @CreatedOnDate and DATEADD(day, 1, @CreatedOnDate)
and con.SelfBankingDetailsId in (select * from STRING_SPLIT(@SBIds, ','))



---Contact Details
---Get contact details from the Telephone table

 --Work
select ct.consumerid, ct.[TelephoneCode] WorkTelCode, ct.[TelephoneNo] WorkTelNo
into #WorkNumber
from [dbo].[TBL_Consumer_Telephones] ct
	 join TBL_Consumer_SelfBankingDetails c on (c.SelfBankingDetailsId = ct.consumerID)
	 --join [IDAS_FICASA_ADMIN].[dbo].[LookupDatas] LD on (LD.value = ct.TelephoneTypeInd)
where c.CreatedOnDate between @CreatedOnDate and DATEADD(day, 1, @CreatedOnDate)
and ct.RecordStatusInd = 1 
 and ct.TelephoneTypeInd = 10


--Home
select ct.consumerid, ct.[TelephoneCode] HomeTelCode, ct.[TelephoneNo] HomeTelNo
into #HomeNumber
from [dbo].[TBL_Consumer_Telephones] ct
	join TBL_Consumer_SelfBankingDetails c on (c.SelfBankingDetailsId = ct.consumerID)
	--join [IDAS_FICASA_ADMIN].[dbo].[LookupDatas] LD on (LD.value = ct.TelephoneTypeInd)
where c.CreatedOnDate between @CreatedOnDate and DATEADD(day, 1, @CreatedOnDate)
and ct.RecordStatusInd = 1 
 and ct.TelephoneTypeInd = 11


--Cellphone
select ct.consumerid, ct.[TelephoneCode] CellCode, ct.[TelephoneNo] CellNo
into #Cellphone
from [dbo].[TBL_Consumer_Telephones] ct
	join TBL_Consumer_SelfBankingDetails c on (c.SelfBankingDetailsId = ct.consumerID)
	--join [IDAS_FICASA_ADMIN].[dbo].[LookupDatas] LD on (LD.value = ct.TelephoneTypeInd)
where c.CreatedOnDate between @CreatedOnDate and DATEADD(day, 1, @CreatedOnDate)
and ct.RecordStatusInd = 1 
 and ct.TelephoneTypeInd = 12


--Residential Address
SELECT ca.consumerid, ca.OriginalAddress1 Res_OriginalAdd1, ca.OriginalAddress2 Res_OriginalAdd2, ca.OriginalAddress3 Res_OriginalAdd3, ca.OriginalAddress4 Res_OriginalAdd4, ca.OriginalPostalCode Res_Pcode, ca.Province ResProvince     
into #ResidentialAdd
from dbo.[TBL_Consumer_Addresses] ca 
join TBL_Consumer_SelfBankingDetails c on (c.SelfBankingDetailsId = ca.consumerID)
where c.CreatedOnDate between @CreatedOnDate and DATEADD(day, 1, @CreatedOnDate)
and ca.RecordStatusInd = 1
and ca.AddressTypeInd = 16

----Postal Address
--SELECT  ca.consumerid,ca.OriginalAddress1 Post_OriginalAdd1, ca.OriginalAddress2 Post_OriginalAdd2, ca.OriginalAddress3 Post_OriginalAdd3, ca.OriginalAddress4 Post_OriginalAdd4, ca.OriginalPostalCode Post_Pcode, ca.Province PostProvince     
--into #PostalAdd
--from dbo.[TBL_Consumer_Addresses] ca 
--where ca.consumerid = @ConsumerId
--and ca.RecordStatusInd = 1
--and ca.AddressTypeInd = 15

----Work Address
--SELECT  ca.consumerid,ca.OriginalAddress1 Work_OriginalAdd1, ca.OriginalAddress2 Work_OriginalAdd2, ca.OriginalAddress3 Work_OriginalAdd3, ca.OriginalAddress4 Work_OriginalAdd4, ca.OriginalPostalCode Work_Pcode, ca.Province WorkProvince           
--into #WorkAdd
--from dbo.[TBL_Consumer_Addresses] ca 
--where ca.consumerid = @ConsumerId
--and ca.RecordStatusInd = 1
--and ca.AddressTypeInd = 14


----Banking AVS
select c.SelfBankingDetailsId, avs.Bank_name , avs.Branch, Branch_code, bat.BankTypeid, bat.AccountType, avs.Account_no, avs.Account_name, bat.Account_active, 
bat.Account_description, bat.Createondate, bat.Lastupdate, avs.Income_taxno,  f.ID_Status, 
avs.AVS_Status, avs.EMAILMATCH, avs.INITIALSMATCH, avs.IDNUMBERMATCH, avs.SURNAMEMATCH,
avs.ACCOUNT_OPEN, avs.ACCOUNTDORMANT, avs.ACCOUNTOPENFORATLEASTTHREEMONTHS, avs.ACCOUNTACCEPTSDEBITS, avs.ACCOUNTACCEPTSCREDITS, ci.Identity_status, ci.INITIALS
--cf.Foreign_Tax_Number, cf.Tax_Oblig_outside_SA, cf.Sources_Funds, cf.Tax_Number,cf.Public_official, cf.Public_official_type_DPIP, cf.Public_official_type_FPPO , 
--cf.Public_official_Family, cf.Public_official_type_family_DPIP, Public_official_type_family_FPPO, cf.SanctionList, cf.AdverseMedia,cf.NonResidentOther
into #banking
from [dbo].[TBL_Consumer_AVS] avs
    left join [dbo].[TBL_Consumer_IDENTITY] ci on (ci.FICA_id = avs.FICA_id)
	left join TBL_FICA f on (f.FICA_id = avs.FICA_id)
		 join TBL_Consumer_SelfBankingDetails c on (c.SelfBankingDetailsId = f.Consumerid)
			left join Ref_Bank_Account_Types bat on (avs.BankTypeid = bat.BankTypeid)
			--	left join [dbo].[TBL_Consumer_Financial] cf on (cf.FICA_id = avs.FICA_id)
			where c.CreatedOnDate between @CreatedOnDate and DATEADD(day, 1, @CreatedOnDate)


----Facial Recognition
select f.consumerid, d.ConsumerIDPhotoMatch, d.MatchResponseCode, d.LivenessDetectionResult, d.ConsumerIDPhoto, d.DOVS_Status, d.ConsumerCapturedPhoto, d.AgeEstimationOfLiveness, d.DeceasedStatus ,d.Route, d.Locality, d.PostalCode, d.Latitude, d.Longitude, ci.DATEOFDEATH,
d.FirstName,d.SecondName,d.Surname,d.BirthDate, d.Gender, d.TitleDesc, d.MaritalStatusDesc, d.HomeTelephoneNo, d.WorkTelephoneNo, d.CellularNo,d.EnquiryDate, d.EnquiryInput,
d.EmailAddress, d.EmployerDetail, d.ResidentialAddress1, d.IDNo,d.ResidentialAddress2, d.ResidentialAddress3, d.ResidentialAddress4, d.ResidentialPostalCode, d.PostalAddress1, d.PostalAddress2, d.PostalAddress3,d.PostalAddress4, d.ReferenceNo

        
into #FacialRecognition
from [dbo].[TBL_Consumer_DOVS] d 
	join TBL_FICA f on (f.FICA_id = d.FICA_id)
	   --left join TBL_Consumer_Declaration cd on (cd.FICA_id = d.FICA_id
	   --and cd.Consumerid = @ConsumerId)
	   left join [dbo].[TBL_Consumer_IDENTITY] ci on (ci.FICA_id = d.FICA_id)
	     left join [dbo].[TBL_Consumer_SelfBankingDetails] cc on (cc.SelfBankingDetailsId = d.FICA_id)
		     join TBL_Consumer_SelfBankingDetails c on (c.SelfBankingDetailsId = f.Consumerid)
	where c.CreatedOnDate between @CreatedOnDate and DATEADD(day, 1, @CreatedOnDate)


--Consumer Results
select Con.SelfBankingDetailsId,  IDNUMBER, con.FirstName, con.SURNAME, TitleCode

	----Post Address Results
	--Post_OriginalAdd1, Post_OriginalAdd2, Post_OriginalAdd3, Post_OriginalAdd4, Post_Pcode, PostProvince,     

	----work Address Results
	--Work_OriginalAdd1, Work_OriginalAdd2, Work_OriginalAdd3, Work_OriginalAdd4, Work_Pcode, WorkProvince,

	--Residential Address
	Res_OriginalAdd1, Res_OriginalAdd2, Res_OriginalAdd3, Res_OriginalAdd4, Res_Pcode, ResProvince,

	--Cellphone
	CellCode, CellNo,

	--HomeTel
	HomeTelCode, HomeTelNo,

	--WorkTel
	WorkTelCode, WorkTelNo,



--Banking
	Bank_name, Branch, Branch_code, BankTypeid, Account_no, Account_name, Account_active, Account_description, Income_taxno, 
	ID_Status, AVS_Status, EMAILMATCH,INITIALSMATCH, IDNUMBERMATCH, SURNAMEMATCH,
	ACCOUNT_OPEN,  ACCOUNTDORMANT, ACCOUNTOPENFORATLEASTTHREEMONTHS, ACCOUNTACCEPTSDEBITS, ACCOUNTACCEPTSCREDITS
	--Public_official, Public_official_type_DPIP, Public_official_type_FPPO, Public_official_Family, Public_official_type_family_DPIP, 
	--Public_official_type_family_FPPO, SanctionList, AdverseMedia, NonResidentOther, 
	-- Tax_Number,Foreign_Tax_Number, Tax_Oblig_outside_SA, Sources_Funds,



	--Facial Recognition
	ConsumerIDPhotoMatch, MatchResponseCode, LivenessDetectionResult, ConsumerIDPhoto, ConsumerCapturedPhoto, AgeEstimationOfLiveness, DOVS_Status, DeceasedStatus , Route, Locality, PostalCode, Latitude, Longitude, Gender , IDNo,
	con.FirstName, con.Customerid,con.Surname, con.Email, con.PhoneNumber, con.AccountHolderInitial,con.BirthDate,DeceasedStatus, ReferenceNo
from #Consumer con 
--left join #PostalAdd p on (p.consumerid = con.ComplianceLiteId)
--left join #WorkAdd wk on ( wk.consumerid = con.ComplianceLiteId)
left join #ResidentialAdd r on ( r.consumerid = con.SelfBankingDetailsId)
left join #Cellphone c on (c.consumerid = con.SelfBankingDetailsId)
left join #HomeNumber h on (h.consumerid = con.SelfBankingDetailsId)
left join #WorkNumber w on (w.consumerid = con.SelfBankingDetailsId)
left join #banking b on (b.SelfBankingDetailsId = con.SelfBankingDetailsId)
left join #FacialRecognition f on (f.consumerid = con.SelfBankingDetailsId)

--select * from #Consumer
--select * #PostalAdd
--select * #WorkAdd
--select * #ResidentialAdd
--select * #HomeNumber
--select * #WorkNumber
--select * #KYC
--select * #banking
--select * #FacialRecognition


--exec [SP_Consumerresults] '2D12F5FB-BE59-4A50-BD6A-3896720D8F89'

drop table #Consumer
drop table #ResidentialAdd
drop table #banking
drop table #FacialRecognition
drop table #HomeNumber
drop table #WorkNumber
drop table #Cellphone
--drop table #PostalAdd
--drop table #WorkAdd


end
