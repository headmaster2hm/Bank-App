<?php

namespace App\Support\Content;

use App\Support\MarketingCatalog as C;

class BusinessContent
{
    /** @return array<string, array<string, mixed>> */
    public static function pages(): array
    {
        return [

            'business-banking' => C::hub('Business', 'Business', 'Business Banking', 'Accounts, lending, payment services, and treasury tools for businesses of every size.', [
                ['Business Checking', 'Accounts for operating cash.'],
                ['Business Savings', 'Grow your reserves.'],
                ['Business Credit Card', 'Card spend with controls.'],
                ['Merchant Services', 'Accept card payments.'],
                ['Treasury Management', 'Optimize cash flow.'],
            ], [
                ['Can I open an account online?', 'Yes for most business types. Some entity types require additional documentation.'],
            ]),

            'business-checking' => C::page('Business', 'Accounts', 'Business Checking', 'An operating account built for payroll, vendors, and daily cash flow.', [
                ['Operating', 'Built for business'],
                ['$0', 'Opening deposit'],
                ['Online', 'Bill pay and transfers'],
                ['Named', 'Banker assigned'],
            ], [
                ['Vendor and bill payments', 'Pay bills and issue ACH directly from the account.'],
                ['Deposit at the point of sale', 'Accept card payments in branch or online.'],
                ['Positive pay', 'Reduce check fraud with payment verification.'],
                ['Dedicated banker', 'One contact who understands your business.'],
            ], [
                ['Is there a monthly fee?', 'Monthly fees are disclosed on the account agreement before you open.'],
            ], ['business-savings', 'merchant-services', 'treasury-management', 'business-loans'], ['Business Checking', 'Business checking']),

            'business-credit-card' => C::page('Business', 'Services', 'Business Credit Card', 'A card for operating spend, with category rewards chosen for how your business actually buys.', [
                ['Spend', 'Everyday and travel'],
                ['Rewards', 'Business categories'],
                ['Controls', 'Card and employee limits'],
                ['Reports', 'Expense-ready detail'],
            ], [
                ['Category rewards', 'Earning on the categories your business already spends in, chosen when you open the account.'],
                ['Employee cards', 'Issue cards to staff with per-card limits and merchant controls.'],
                ['Expense detail', 'Transaction detail you can hand to your accounting process.'],
                ['Statement credits', 'Credits are applied to your business card account, not a personal rewards balance.'],
            ], [
                ['Is it the same as a personal card?', 'No. Business cards are tied to a business account, with business credit terms and different reward and control features.'],
                ['Can I add employee cards?', 'Yes. You can set individual limits and lock cards from online banking.'],
            ], ['business-checking', 'business-loans', 'credit-cards', 'card-controls'], ['Business Credit Card', 'Business credit card', 'Business Cards']),

            'business-savings' => C::page('Business', 'Accounts', 'Business Savings', 'Earn interest on operating reserves you are not spending today.', [
                ['Interest', 'On your balance'],
                ['Reserve', 'For operating cash'],
                ['$0', 'Monthly fee'],
                ['Same-day', 'Access'],
            ], [
                ['Interest on reserves', 'Set aside operating cash and earn interest on it.'],
                ['No monthly fee', 'No recurring charge for holding the account.'],
                ['Flexible access', 'Funds are available when you need them, subject to stated terms.'],
                ['Links to checking', 'Sweep or transfer between business accounts easily.'],
            ], [
                ['Can I open both business accounts?', 'Yes. Business checking and savings are often paired.'],
            ], ['business-checking', 'treasury-management', 'high-yield-savings', 'rates'], ['Business Savings', 'Business savings']),

            'nonprofit-accounts' => C::page('Business', 'Accounts', 'Nonprofit Accounts', 'Deposit and lending services for qualifying nonprofit organizations.', [
                ['Mission', 'Built for nonprofits'],
                ['Guidance', 'Sector expertise'],
                ['Deposits', 'Operating and reserve'],
                ['Impact', 'Community focus'],
            ], [
                ['Operating accounts', 'Checking and reserve accounts for organizational cash.'],
                ['Lending', 'Financing for facilities and equipment.'],
                ['Guidance', 'Bankers with nonprofit experience.'],
                ['Community alignment', 'We support the organizations our communities rely on.'],
            ], [
                ['How do I qualify?', 'You must be a qualifying nonprofit organization. Our team confirms status during onboarding.'],
            ], ['business-checking', 'business-savings', 'community', 'sustainability'], ['Nonprofit Accounts', 'Nonprofit accounts']),

            'merchant-services' => C::page('Business', 'Services', 'Merchant Services', 'Accept card payments in store, online, and on the go.', [
                ['In-person', 'Point of sale'],
                ['Online', 'E-commerce'],
                ['Mobile', 'On the go'],
                ['Transparent', 'Processing fees'],
            ], [
                ['Point of sale', 'Modern terminals for counter and mobile use.'],
                ['E-commerce', 'Online checkout for your website.'],
                ['Payment methods', 'Cards, wallets, and contactless.'],
                ['Clear fees', 'Processing fees are stated plainly, with no surprise monthly minimums.'],
            ], [
                ['Are there setup fees?', 'Equipment and setup pricing is disclosed in writing before you sign.'],
            ], ['cash-management', 'business-checking', 'treasury-management', 'online-banking'], ['Merchant Services', 'Merchant services']),

            'treasury-management' => C::page('Business', 'Services', 'Treasury Management', 'Put idle cash to work and put working capital to use, automatically.', [
                ['Sweep', 'Automatic cash concentration'],
                ['Forecast', 'Cash positioning'],
                ['Payments', 'Automated runs'],
                ['Reporting', 'Consolidated view'],
            ], [
                ['Cash concentration', 'Automatically sweep idle balances into interest-earning accounts.'],
                ['Cash positioning', 'See all account balances in one place.'],
                ['Automated payments', 'Schedule and approve payment runs.'],
                ['Reporting', 'Consolidated reporting across accounts.'],
            ], [
                ['Do I need treasury management?', 'It suits businesses with multiple accounts and complex cash flow. A banker can advise.'],
            ], ['cash-management', 'merchant-services', 'business-savings', 'industry-solutions'], ['Treasury Management', 'Treasury management']),

            'cash-management' => C::page('Business', 'Services', 'Cash Management', 'Control when money leaves your accounts, with approvals and positive pay.', [
                ['Positive pay', 'Check fraud control'],
                ['Approvals', 'Multi-step payments'],
                ['ACH', 'Automated transfers'],
                ['Control', 'Granular permissions'],
            ], [
                ['Positive pay', 'Pay only checks you issued by matching against a file.'],
                ['Approval workflows', 'Route payments through required approvers.'],
                ['ACH origination', 'Send ACH payments on a schedule.'],
                ['Role-based access', 'Give employees the access they need and nothing more.'],
            ], [
                ['How does positive pay work?', 'You send a file of issued checks, and only matching checks are paid.'],
            ], ['treasury-management', 'merchant-services', 'payroll-services', 'business-checking'], ['Cash Management', 'Cash management']),

            'payroll-services' => C::page('Business', 'Services', 'Payroll Services', 'Process payroll accurately and pay employees on time, every cycle.', [
                ['Payroll', 'Direct deposit'],
                ['Compliance', 'Tax filing support'],
                ['Self-service', 'Employee tools'],
                ['Integration', 'Works with your systems'],
            ], [
                ['Direct deposit', 'Employees are paid straight into their accounts.'],
                ['Tax filing', 'We handle the associated tax filings for covered employees.'],
                ['Self-service', 'Employees can view pay statements.'],
                ['Integrations', 'Connect with the tools you already use.'],
            ], [
                ['Is there a fee for payroll?', 'Payroll pricing is disclosed before you start. Ask your banker for a quote.'],
            ], ['cash-management', 'business-checking', 'merchant-services', 'industry-solutions'], ['Payroll Services', 'Payroll services']),

            'international-banking' => C::page('Business', 'Services', 'International Banking', 'Cross-border payments, foreign exchange, and trade finance for global businesses.', [
                ['Global', 'Cross-border payments'],
                ['FX', 'Foreign exchange'],
                ['Trade', 'Letters of credit'],
                ['Local', 'In-country support'],
            ], [
                ['Cross-border transfers', 'Send and receive international payments.'],
                ['Foreign exchange', 'Access to rates for converting currencies.'],
                ['Trade finance', 'Letters of credit and documentary collections.'],
                ['Local expertise', 'Support for operating across borders.'],
            ], [
                ['Do you operate internationally?', 'We serve businesses with cross-border needs. A specialist will discuss your countries of operation.'],
            ], ['industry-solutions', 'treasury-management', 'commercial-real-estate', 'business-banking'], ['International Banking', 'International banking']),

            'industry-solutions' => C::page('Business', 'Services', 'Industry Solutions', 'Banking shaped around how your specific sector actually operates.', [
                ['Sector', 'Industry expertise'],
                ['Tailored', 'Products for your model'],
                ['Specialists', 'People who know your field'],
                ['Flexible', 'Scalable as you grow'],
            ], [
                ['Industry bankers', 'Bankers with direct experience in your sector.'],
                ['Tailored products', 'Products designed around your cash cycle and needs.'],
                ['Peer insight', 'A view of trends affecting your industry.'],
                ['Scalable', 'Solutions that grow with you.'],
            ], [
                ['Which industries do you specialize in?', 'We serve a range of sectors. A banker can discuss the specific needs of yours.'],
            ], ['international-banking', 'merchant-services', 'payroll-services', 'business-banking'], ['Industry Solutions', 'Industry solutions']),

            'open-business-account' => C::page('Business', 'Get Started', 'Open a Business Account', 'Start banking for your business online, with a banker available to help you finish setting up.', [
                ['Online', 'Start online'],
                ['Dedicated', 'Banker support'],
                ['$0', 'Opening deposit options'],
                ['Fast', 'Decision quickly'],
            ], [
                ['Apply online', 'Tell us about your business and get a decision.'],
                ['Documentation', 'We list exactly what to provide, so there are no surprises.'],
                ['Account setup', 'Open checking, savings, and services together.'],
                ['Human help', 'A banker is available to help you open and set up accounts.'],
            ], [
                ['What documents do I need?', 'Typically business formation documents, tax identification, and owner identification.'],
            ], ['business-checking', 'business-savings', 'merchant-services', 'contact-us'], ['Open a Business Account', 'Open Business Account', 'Open a Business Account'], 'product', 'Open an Account', 'register'),

            'institutional' => C::hub('Business', 'Institutional', 'Institutional Banking', 'Banking, markets, and treasury services for institutions.', [
                ['Institutional relationships', 'Coverage for larger organizations.'],
                ['Treasury solutions', 'Manage institutional liquidity.'],
                ['Global network', 'Correspondent relationships.'],
            ], [
                ['Who is eligible?', 'Institutional banking is designed for organizations with substantial and complex banking needs.'],
            ]),

        ];
    }
}
