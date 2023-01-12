@extends('layouts.master-without-nav')

@section('title')
    @lang('translation.Login')
@endsection

{{-- Recaptcha --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
{!! RecaptchaV3::initJs() !!}
<script src="https://www.google.com/recaptcha/api.js?render=6LcWWaQhAAAAACvrLhpsnG_XdOPR0WI_LdHmsr9s"></script>

@section('body')

    <body style="background-color: rgb(230, 230, 230)">
    @endsection

    @section('content')
        {{-- <div class="row d-flex justify-content-center mb-3 mt-5">
            <img src="{{ URL::asset('/assets/images/computershare.png') }}" style="width: 190px; height: 35px;" alt=""
                class="img-fluid">
        </div> --}}

        {{-- @if ($customerName == 'ComputerShare')
            <div class="row d-flex justify-content-center mb-3 mt-5">
                <img src="{{ URL::asset('/assets/images/logo/computershare.png') }}" style="width: 190px; height: 35px;"
                    alt="" class="img-fluid">
            </div>
        @elseif($customerName == 'InspiritData')
            <div class="row d-flex justify-content-center mb-3 mt-3">
                <img src="{{ URL::asset('/assets/images/logo/inspirit.png') }}" style="width: 23%" alt=""
                    class="img-fluid">
            </div>
        @endif --}}

        <div class="row d-flex justify-content-center mb-2 mt-4">
            <img src="{{ URL::asset($customer->Client_Logo) }}" style="max-width: 200px; max-height: 200px;" alt=""
                class="img-fluid">
        </div>

        <div class="account-pages">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-5">
                        <div class="card overflow-hidden">

                            <div style="background-image: linear-gradient(#93186c, #93186c);">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="text-white p-4">
                                            <h5 class="text-white">Welcome Back</h5>
                                            <p>To Continue, Please Sign In</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body pt-0">

                                <div class="p-2">
                                    <form method="post" action="{{ route('login') }}" id="login-form">
                                        @if (Session::get('fail'))
                                            <div class="alert alert-danger" role="alert">
                                                {{ Session::get('fail') }}
                                            </div>
                                        @endif
                                        @csrf
                                        <div class="mb-3">
                                            <input name="Email" type="email" required
                                                class="form-control @error('Email') is-invalid @enderror"
                                                value="{{ old('Email') }}" id="Email" placeholder="Email" />
                                            <span class="text-danger">
                                                @error('Email')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                            {{-- @error('Email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror --}}
                                        </div>

                                        <div class="mb-3">
                                            <div class="mb-3">
                                                {{-- <div
                                                class="input-group auth-pass-inputgroup @error('Password') is-invalid @enderror"> --}}
                                                <input type="password" name="password" required
                                                    class="form-control  @error('password') is-invalid @enderror"
                                                    id="password" value="" placeholder="Password"
                                                    aria-label="password" aria-describedby="password-addon" />
                                                {{-- <button class="btn btn-light " type="button" id="password-addon"><i
                                                        class="mdi mdi-eye-outline"></i></button> --}}
                                                <span class="text-danger">
                                                    @error('password')
                                                        {{ $message }}
                                                    @enderror
                                                </span>
                                                {{-- @error('Password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror --}}
                                            </div>
                                        </div>

                                        {{-- <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="remember"
                                                {{ old('remember') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="remember">
                                                Remember me
                                            </label>
                                        </div> --}}

                                        {{-- store Recaptcha token --}}
                                        <input type="hidden" name="g-recaptcha-response-login"
                                            id="g-recaptcha-response-login">

                                        <div class="mt-3 text-center">

                                            <button type="button" class="btn w-md text-white" id="login-btn"
                                                style="background-color: #93186c; border-color: #93186c;">Log In</button>

                                            <button type="button" id="clearall" onClick="window.location.reload();"
                                                style="background-color: #93186c; border-color: #93186c"
                                                class="btn w-md text-white">Clear</button>

                                        </div>

                                        <div>
                                            @if (Route::has('Password.request'))
                                                <a href="{{ route('Password.request') }}" class="text-muted"><i
                                                        class="mdi mdi-lock me-1"></i> Forgot your password?</a>
                                            @endif
                                        </div>

                                        <div class="mt-4 text-center">
                                            <a href="{{ route('forget', ['customer' => $customer->RegistrationName]) }}"
                                                class="fw-medium text-primary">
                                                <span style="color: #93186c">Forgot your password?</span>
                                            </a>
                                        </div>

                                        <div class="mt-2 text-center">
                                            <p>Not registered yet? <a
                                                    href="{{ route('register', ['customer' => $customer->RegistrationName]) }}"
                                                    class="fw-medium text-primary">
                                                    <span style="color: #93186c">Register now</span></a>
                                            </p>
                                        </div>

                                        <div class="mt-5 text-center">
                                            <p>
                                                <a type="button" class="fw-medium text-primary" data-bs-toggle="modal"
                                                    data-bs-target="#TandC">
                                                    <span style="color: #93186c">Terms and Conditions</span>
                                                </a>
                                                /
                                                <a type="button" class="fw-medium text-primary" data-bs-toggle="modal"
                                                    data-bs-target="#Privacy">
                                                    <span style="color: #93186c">Privacy Policy</span>
                                                </a>
                                            </p>
                                        </div>

                                        <!-- start T and C-->
                                        <div>
                                            <!-- sample modal content -->
                                            <div id="TandC" class="modal fade" tabindex="-1"
                                                aria-labelledby="TandCLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="TandCLabel">Terms and
                                                                Conditions</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>

                                                        <div class="modal-body">
                                                            {{-- <h5>Overflowing text to show scroll behavior</h5> --}}
                                                            <p>
                                                                The following terms and conditions describe the
                                                                terms on which Inspirit Data Analytics Services
                                                                (Pty) Ltd (IDAS), an Authorised Agent of Xpert
                                                                Decision Systems (Pty) Ltd (XDS), offers you use of
                                                                website (www.inspiritdata.co.za), mobile application
                                                                software and access to our services. All Products
                                                                and Services offered by IDAS is Powered by XDS
                                                            </p>

                                                            <p>
                                                                Important - read carefully. These terms are a legal
                                                                agreement between you, the licensed user (either an
                                                                individual or organization) (“you” or “your”) and
                                                                Inspirit Data Analytics Services, for use of our
                                                                services including our website, dashboard, mobile
                                                                application, our associated printed and online
                                                                documentation (collectively, the "services"). Only
                                                                the licensee may accept these terms and use the
                                                                services. The licensee is the individual or entity
                                                                designated as such on the Data Services Agreement
                                                                which details the services that were licensed from
                                                                us. Do not use the services and exit now if you are
                                                                not the licensee, or a person with authority to bind
                                                                the licensee to these terms. By accepting these
                                                                terms or using the services you, as an individual
                                                                and in your personal capacity, represent and warrant
                                                                to us that you are either (i) the individual
                                                                licensed to use the services, or (ii) a person duly
                                                                authorized to act on behalf of the organization that
                                                                is the licensee of the services, or (iii) a person
                                                                that has been authorized by a licensee to use the
                                                                services under the licensee’s license to use the
                                                                services. If this is not the case, your use of the
                                                                services is not authorized and you are personally
                                                                liable and responsible for any damage incurred by
                                                                IDAS.
                                                            </p>

                                                            <p>
                                                                If you do not agree to these terms, do not install
                                                                or use the services and exit now.
                                                            </p>

                                                            <p>
                                                                By accessing this web site, you are agreeing to be
                                                                bound by these web site Terms and Conditions of Use.
                                                                The materials contained in this web site are
                                                                protected by applicable copyright and trade mark
                                                                laws.
                                                            </p>

                                                            <p>
                                                                When you create an account with us, you guarantee
                                                                that you are above the age of 18, and that the
                                                                information you provide us is accurate, complete,
                                                                and current at all times. Inaccurate, incomplete, or
                                                                obsolete information may result in the immediate
                                                                termination of your account on the Service. You are
                                                                responsible for maintaining the confidentiality of
                                                                your account and password, including but not limited
                                                                to the restriction of access to your computer and/or
                                                                account. You agree to accept responsibility for any
                                                                and all activities or actions that occur under your
                                                                account and/or password, whether your password is
                                                                with our Service or a third-party service. You must
                                                                notify us immediately upon becoming aware of any
                                                                breach of security or unauthorized use of your
                                                                account.
                                                            </p>

                                                            <p>
                                                                By creating an Account on our service, you agree to
                                                                subscribe to newsletters, marketing or promotional
                                                                materials and other information we may send.
                                                                However, you may opt out of receiving any, or all,
                                                                of these communications from us by following the
                                                                unsubscribe link or instructions provided in any
                                                                email we send.
                                                            </p>

                                                            <p>
                                                                In no event shall IDAS or its suppliers be liable
                                                                for any damages (including, without limitation,
                                                                damages for loss of profit, or due to business
                                                                interruption,) arising out of the use or inability
                                                                to use the materials on IDASs’ website, even if IDAS
                                                                or an IDAS authorised representative has been
                                                                notified orally or in writing of the possibility of
                                                                such damage.
                                                            </p>

                                                            <p>
                                                                You agree that You will use the Services in a manner
                                                                consistent with any and all applicable laws and
                                                                regulations. We reserve the right but are not
                                                                obligated to investigate and terminate Your use or
                                                                access to the Services if You have misused the
                                                                Services or behaved in a way which could be regarded
                                                                as inappropriate or whose conduct is unlawful or
                                                                illegal. With respect to Your use of the Service,
                                                                You agree that You will not: (a) Impersonate any
                                                                person or entity; (b) "Stalk" or otherwise harass
                                                                any person; (c) Express or imply that any statements
                                                                You make are endorsed by IDAS, without Our specific
                                                                prior written consent; (d) use any robot, spider,
                                                                site search/retrieval application, or other manual
                                                                or automatic device or process to retrieve, index,
                                                                "data mine", or in any way reproduce or circumvent
                                                                the navigational structure or presentation of the
                                                                Service or its contents; (e) post, distribute or
                                                                reproduce in any way any copyrighted material,
                                                                trademarks, or other proprietary information without
                                                                obtaining the prior consent of the owner of such
                                                                proprietary rights and (f) remove any copyright,
                                                                trademark or other proprietary rights notices
                                                                contained in the applications or with respect to the
                                                                Service.
                                                            </p>

                                                            <p>
                                                                Our Service may contain links to third party web
                                                                sites or services that are not owned or controlled
                                                                by IDAS. Our Service also permits Users to
                                                                communicate with other users of the Service (“Other
                                                                Users”).
                                                            </p>

                                                            <p>
                                                                IDAS has no control over, and assumes no
                                                                responsibility for the content, privacy policies, or
                                                                practices of any third-party web sites or services
                                                                or posted or shared by Other Users. We do not
                                                                warrant the offerings or information of any of these
                                                                entities/individuals or their websites.
                                                            </p>

                                                            <p>
                                                                You acknowledge and agree that IDAS shall not be
                                                                responsible or liable, directly or indirectly, for
                                                                any damage or loss caused or alleged to be caused by
                                                                or in connection with use of or reliance on any such
                                                                content, goods or services available on or through
                                                                any such third-party web sites or services or Other
                                                                Users.
                                                            </p>

                                                            <p>
                                                                We strongly advise you to read the terms and
                                                                conditions and privacy policies of any third-party
                                                                web sites or services that you visit, and to
                                                                exercise due diligence and care when deciding
                                                                whether or not to engage in a potential transaction
                                                                with any Other User.
                                                            </p>

                                                            <p>
                                                                The materials on IDAS’s web site are provided “as
                                                                is”. IDAS makes no warranties, expressed or implied,
                                                                and hereby disclaims and negates all other
                                                                warranties, including without limitation, implied
                                                                warranties. Further, IDAS does not warrant or make
                                                                any representations concerning the accuracy, likely
                                                                results, or reliability of the use of the materials
                                                                on its Internet web site or otherwise relating to
                                                                such materials or on any sites linked to this site.
                                                            </p>

                                                            <p>
                                                                IDAS may revise these terms of use for its web site
                                                                at any time without notice. By using this website,
                                                                you are agreeing to be bound by the then current
                                                                version of these Terms and Conditions of Use.
                                                            </p>

                                                            <p>
                                                                Any claim relating to IDAS’s web site shall be
                                                                governed by the laws of the State of South Africa
                                                                without regard to its conflict of law provisions.
                                                            </p>

                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button"
                                                                class="btn btn-primary waves-effect waves-light"
                                                                style="background-color: #93186c;border-color: #93186c"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div><!-- /.modal-content -->
                                                </div><!-- /.modal-dialog -->
                                            </div><!-- /.modal -->
                                        </div>
                                        <!-- end T and C-->

                                        <!-- start Validation-->
                                        <div>
                                            <!-- sample modal content -->
                                            <div id="Privacy" class="modal fade" tabindex="-1"
                                                aria-labelledby="PrivacyLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="PrivacyLabel">Privacy
                                                                Policy</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <h5>1. INTRODUCTION</h5>
                                                            <p>
                                                                Inspirit Data Analytics Services (Pty) Ltd (‘IDAS”),
                                                                Registration Number: 2017/653373/07, whose
                                                                registered office is situated at: Brandfin House, 4
                                                                Holwood Crescent, La Lucia Ridge, Umhlanga, Kwazulu
                                                                Natal, 4051. IDAS is an authorized agent of Xpert
                                                                Decision Systems (Pty) Ltd (“XDS”) and has been
                                                                appointed as the sole agent of XDS products in the
                                                                KwaZulu Natal Region, with the authority to market
                                                                XDS’s and collaborative products nationally. IDAS is
                                                                a data business providing solutions and services to
                                                                a variety of entities in tracing and data management
                                                                arenas with a focus on development and
                                                                implementation of various data related products. XDS
                                                                provides IDAS with specific data categories, hosted
                                                                and managed by XDS, which IDAS products and services
                                                                will leverage. IDAS products and services are
                                                                ‘Powered by XDS’. XDS is a registered Credit Bureau
                                                                in terms of the National Credit Act, No 34 of 2005
                                                                (“NCA”), with the National Credit Regulator (“NCR”)
                                                                registration number; NCRCB05, an Associate member of
                                                                the South African Credit and Risk Reporting
                                                                Association (“SACRRA”) and a Full member of the
                                                                Credit Bureau Association (“CBA”). XDS as an EOH
                                                                Company is obligated to comply with the EOH
                                                                Governance requirements which includes alignment to
                                                                and or adherence to group Privacy Policies amongst
                                                                other policies.
                                                            </p>

                                                            <h5>2. PRIVACY COMMITMENT</h5>
                                                            <p>
                                                                IDAS is committed to ensuring that your personal
                                                                information is processed in accordance with
                                                                applicable Data Processing Legislation. IDAS will
                                                                take all reasonable measures, through the
                                                                implementation of appropriate policies, procedures,
                                                                technology and controls to ensure that your personal
                                                                information is appropriately secured and protected
                                                                and processed only for lawful purposes.
                                                            </p>

                                                            <h5>3. USE OF YOUR PERSONAL INFORMATION</h5>
                                                            <p>
                                                                3.1 In some instances, when engaging directly with
                                                                you, IDAS acts as a Responsible Party in terms the
                                                                Protection of Personal Information Act (“POPIA”) or
                                                                a Data Controller in terms of the General Data
                                                                Protection Regulations (“GDPR”). In all other
                                                                instances IDAS may be regarded as a Data Processor
                                                                or Operator. IDAS collects your personal information
                                                                when you register, with IDAS for any service or
                                                                product provided by IDAS. This information may be
                                                                updated to your personal information as held by
                                                                IDAS.
                                                                - The NCA also authorizes a credit bureau to receive
                                                                consumer credit information from the following
                                                                sources
                                                                - An organ of State, a court or judicial officer
                                                                - Any person who supplies goods, services or
                                                                utilities to consumers, whether for cash or credit
                                                                - A person providing long terms and short terms
                                                                insurance
                                                                - Entities involved in fraud investigation
                                                                - Educational Institutions
                                                                - Debt Collectors to whom book debt was ceded or
                                                                sold by a credit provider
                                                                - Other registered credit bureau
                                                                - The NCR or any source authorized by the NCR
                                                                - A consumer for the consumer to correct or
                                                                challenge information held by a credit bureau XDS
                                                                may also receive the following information about you
                                                                from yourself or an entity that you may have
                                                                provided consent to, or an entity that is lawful
                                                                authorized to access your information or who may
                                                                lawfully share your information with XDS. Individual
                                                                - Identity or Passport number
                                                                - Name details
                                                                - Contact information
                                                                - Other lawful information that you may have
                                                                consented to Juristic
                                                                - Registration Number
                                                                - Name details
                                                                - Contact information
                                                                - Financial Information
                                                                - Trade References
                                                                - Number of Employees
                                                                - Personal details of Directors
                                                                - Other lawful information that the Juristic has
                                                                consented to

                                                                3.3 IDAS may make use of cookies, which may be
                                                                placed on your computer when you both visit and or
                                                                register on any IDAS website or product site. A
                                                                cookie is a small piece of information sent by a web
                                                                server to a web browser, which enables the server to
                                                                collect information back from the browser.

                                                                3.4.1 IDAS cookies may be used for the following for
                                                                the following purposes:
                                                                - To enable certain features and functions on
                                                                websites, e.g. remembering user-id, favourite
                                                                channel selections, browsing and other service
                                                                preferences;
                                                                - To build up a profile of how users experience the
                                                                website;
                                                                - To improve the efficiency of IDAS’s website;
                                                                - To administer services to users and advertisers;
                                                                and
                                                                - To establish usage statistics.

                                                                3.4.2 Most internet browsers provide users with the
                                                                option of turning off the processing of cookies
                                                                (please see the “help” section of the browser), but
                                                                this may result in the loss of functionality,
                                                                restrict use of the website and/or delay or affect
                                                                the way in which it operates.

                                                                3.4.3 Advertisements on the IDAS website may be
                                                                provided by third party advertisers and their
                                                                agencies. These may generate cookies to track how
                                                                many people have seen a particular advertisement (or
                                                                use the services of third parties to do this), and
                                                                to track how many people have seen it more than
                                                                once. IDAS does not control these third parties and
                                                                their cookie policies and therefore is not
                                                                responsible for the Personal Information policies
                                                                (including Personal Information protection and
                                                                cookies), content or security of any third party
                                                                websites linked to the Website.

                                                                3.4 IDAS may also collects information that your
                                                                browser sends whenever you visit IDAS websites. This
                                                                information may include information such as your
                                                                computer's Internet Protocol ("IP") address, browser
                                                                type, browser version, and the pages of the IDAS
                                                                website that you visit, the time and date of your
                                                                visit, the time spent on those pages and other
                                                                statistics.
                                                            </p>

                                                            <h5>4. INFORMATION USE AND DISCLOSURE</h5>
                                                            <p>
                                                                4.1.1 Use and Disclosure as per NCA
                                                                - The NCA provides the purposes for which IDAS may
                                                                release consumer credit information. In addition to
                                                                the NCA, IDAS will adhere to processing obligations
                                                                embodied in POPIA and GDPR. In terms of the NCA, a
                                                                credit bureau may release consumer credit
                                                                information for the following purposes: -
                                                                - an investigation into fraud, corruption or theft,
                                                                provided that the South African Police Service or
                                                                any other statutory enforcement agency conducts such
                                                                an investigation;
                                                                - fraud detection and fraud prevention services;
                                                                - considering a candidate for employment in a
                                                                position that requires honesty in dealing with cash
                                                                or finances;
                                                                - an assessment of the debtor’s book of a business
                                                                for the purposes of (i) the sale of the business or
                                                                debtors book of that business; or (ii) any other
                                                                transaction that is dependent upon determining the
                                                                value of the business or debtors book of that
                                                                business;
                                                                - setting a limit of in respect of the supply of
                                                                goods, services or utilities;
                                                                - assessing an application for insurance;
                                                                - verifying educational qualifications and
                                                                employment;
                                                                - obtaining consumer information to distribute
                                                                unclaimed funds, including pension funds and
                                                                insurance claims;
                                                                - tracing a consumer by a credit provider in respect
                                                                of a credit agreement entered into between the
                                                                consumer and the credit provider;
                                                                - developing a credit scoring system by a credit
                                                                provider or credit bureau;
                                                                - an affordability assessment in respect of a
                                                                consumer, as required by Section 81 of the Act;
                                                                - a credit assessment in respect of a consumer, as
                                                                required by section 81 (2) of the Act;
                                                                - investigating an application for debt review made
                                                                by a consumer
                                                                - a contemplated or permitted purpose as may be
                                                                envisaged by the NCA
                                                                4.1.2 IDAS may use the information you provide to
                                                                maintain contact with you in terms of
                                                                - Any queries that you may have lodged with IDAS
                                                                - Keeping you informed about new developments on or
                                                                any changes to the services you may have access.

                                                                4.1.3 IDAS may process your information as may be
                                                                allowed in terms of POPIA.

                                                                4.1.4 IDAS may process your personal information for
                                                                the provision of marketing services when requested
                                                                to do so by third parties to whom you have provided
                                                                consent to.

                                                                4.2 IDAS may use cookies to identify you when you
                                                                access a IDAS website and to build up a demographic
                                                                profile of its users.

                                                                4.2 IDAS may use cookies to identify you when you
                                                                access a IDAS website and to build up a demographic
                                                                profile of its users.

                                                            </p>

                                                            <p>
                                                                4.3 IDAS may use your Personal Information
                                                                4.3.1 to contact you with newsletters, marketing or
                                                                promotional materials and other information or
                                                                4.3.2 to conduct market research and surveys to
                                                                enable IDAS to understand and determine customer
                                                                location, preferences and demographics in order to
                                                                develop special offers and marketing programmes, and
                                                                to improve our service delivery and customer
                                                                experience;
                                                                4.3.3 to provide additional products, services and
                                                                benefits to users, which include promotions, loyalty
                                                                and reward programmes from IDAS;
                                                                4.3.4 to match Personal Information with other data
                                                                collected for other purposes and from other sources
                                                                (including third parties) in connection with the
                                                                provision, marketing or offering of products and
                                                                services;
                                                                4.3.5 To administer contests, competitions and
                                                                marketing campaigns, and personalize user
                                                                experience;
                                                                4.3.6 To communicate advertisements involving
                                                                details of IDAS’s products and services, special
                                                                offers and rewards, either to general customers, or
                                                                to communicate advertisements which IDAS has
                                                                identified as being of interest to specific users
                                                                (this includes but is not limited to upselling,
                                                                cross selling and telemarketing);

                                                                4.4 In relation to particular products and services
                                                                or user interactions, IDAS may also specifically
                                                                notify users of other purposes for which personal
                                                                information is collected, used, or disclosed.
                                                                4.5 Users have a choice to withdraw consent for
                                                                receiving marketing or promotional
                                                                materials/communication from IDAS. Users may contact
                                                                IDAS Information Officer:
                                                                informationofficer@inspirit.co.za to request the
                                                                withdrawal
                                                                4.6 Once IDAS receives confirmation that a user
                                                                wishes to withdraw consent for marketing or
                                                                promotional materials/communication, it may take up
                                                                to 30 (thirty) working days for the withdrawal to be
                                                                effected. Therefore, users may continue to receive
                                                                marketing or promotional materials/communication
                                                                during that period of time. In may be noted that
                                                                even upon withdrawal of consent for the receipt of
                                                                marketing or promotional materials, IDAS may still
                                                                contact users for other purposes in relation to the
                                                                products and services accessed by users or
                                                                subscriptions to IDAS.
                                                            </p>

                                                            <h5>5. CROSS BORDER TRANSFER</h5>
                                                            <p>
                                                                5.1 IDAS may transfer your personal information to
                                                                another country for storage and processing provided
                                                                that the country has equivalent or better data
                                                                protection laws in order to adequately protect your
                                                                personal information.
                                                                5.2 IDAS shall transfer your personal information on
                                                                a processing request originating from a IDAS Client
                                                                located outside of the Republic of South Africa,
                                                                should you have consented to such processing or if
                                                                shall processing is in accordance with Data
                                                                Processing legislation.
                                                            </p>

                                                            <h5>6. INFORMATION RETENTION</h5>
                                                            <p>
                                                                6.1 IDAS will retain your personal information in
                                                                accordance with any retention legislation relating
                                                                to such personal information.
                                                                6.2 In the absence of any legislation governing a
                                                                particular type of personal information, IDAS shall
                                                                retain such information for a period of 20 (twenty)
                                                                years unless (i) you have consented to a longer
                                                                retention period or (ii) you request the deletion of
                                                                such personal information, provided that there is no
                                                                lawful reason for which such personal information
                                                                must be retained by IDAS.
                                                                6.3 After 20 years your personal information shall
                                                                be de-identified and archived for audit and
                                                                investigation purposes.
                                                                6.4 You may request the deletion of your personal
                                                                information as per (6.5)((ii) by calling IDAS on 031
                                                                584 7379 or emailing
                                                                informationofficer@inspirit.co.za and using the
                                                                subject : Request deletion.
                                                                6.5 You will be required to provide proof of
                                                                identity as may be determined by IDAS and to follow
                                                                IDAS procedures related to your request.
                                                            </p>

                                                            <h5>7. SECURITY</h5>
                                                            <p>
                                                                7.1 The security of your Personal Information is
                                                                important to IDAS.
                                                                7.2 XDS Information Security Policies guides the
                                                                processing of personal information and ensures that
                                                                IDAS, with XDS protects your personal information.
                                                                7.3 The personal information that IDAS collects and
                                                                processes shall be secured by appropriate technical
                                                                and organizational measures against accidental loss,
                                                                destruction or damage, and against unauthorized or
                                                                unlawful processing.
                                                                7.4 IDAS shall regularly evaluate and test the
                                                                effectiveness of such measures to ensure that they
                                                                are adequate and effective.
                                                                7.5 IDAS is a responsibility for ensuring the
                                                                security of personal information processed
                                                                throughout the performance of its duties.
                                                            </p>

                                                            <h5>8. GENERAL</h5>
                                                            <p>
                                                                8.1 IDAS may update or change this Privacy Notice as
                                                                often as required in order to adequately reflect the
                                                                processing of personal information by IDAS.
                                                                8.2 You should check this Privacy Notice
                                                                periodically to access the most recent Privacy
                                                                Notice
                                                            </p>

                                                            <h5>9. CONTACT US</h5>
                                                            <p>
                                                                If you have any questions about this Privacy Notice,
                                                                please contact IDAS Information Officer:
                                                                informationofficer@inspirit.co.za
                                                            </p>

                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button"
                                                                class="btn btn-primary waves-effect waves-light"
                                                                style="background-color: #93186c;border-color: #93186c"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div><!-- /.modal-content -->
                                                </div><!-- /.modal-dialog -->
                                            </div><!-- /.modal -->
                                        </div>
                                        <!-- end Validation-->

                                        <div class="mt-1 text-center">
                                            <p style="font-size: 10px;">© {{ $customer->RegistrationName }}
                                                <script>
                                                    document.write(new Date().getFullYear())
                                                </script>
                                                | Powered by Inspirit Data.
                                            </p>
                                        </div>

                                    </form>
                                </div>

                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
        <!-- end account-pages -->
    @endsection

    @section('script')
        <script src="{{ URL::asset('assets/js/app.min.js') }}"></script>

        <script>
            // Recaptcha
            document.getElementById("login-btn").addEventListener('click', () => {
                grecaptcha.ready(function() {
                    grecaptcha.execute('6LcWWaQhAAAAACvrLhpsnG_XdOPR0WI_LdHmsr9s', {
                        action: 'login'
                    }).then(function(token) {
                        console.log(token)
                        document.getElementById("g-recaptcha-response-login").value = token;
                        // $('g-recaptcha-response').val(token);
                        document.getElementById("login-form").submit();
                    });
                });
            }).click();
        </script>
    @endsection
