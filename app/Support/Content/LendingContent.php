<?php

namespace App\Support\Content;

use App\Support\MarketingCatalog as C;

class LendingContent
{
    /** @return array<string, array<string, mixed>> */
    public static function pages(): array
    {
        return [

            'borrowing' => C::hub('Loans', 'Loans', 'Compare Borrowing Options', 'Personal borrowing for a purchase, a consolidation, or an expense you need to cover.', [
                ['Personal Loans', 'Fixed-rate borrowing for many purposes.'],
                ['Debt Consolidation', 'Combine several balances into one payment.'],
                ['Line of Credit', 'Borrow as needed, up to a limit.'],
                ['Student Loans', 'Financing for education costs.'],
            ], [
                ['Will applying affect my credit?', 'Pre-qualification uses a soft review and does not affect your credit score.'],
            ], 'hub', ['Apply Online', 'Apply online', 'Compare Borrowing Options']),

            'personal-loans' => C::page('Loans', 'Loans', 'Personal Loans', 'A fixed-rate loan for debt consolidation, a major purchase, or an unexpected cost.', [
                ['Fixed', 'Rate for the full term'],
                ['No collateral', 'Unsecured borrowing'],
                ['Fast', 'Online application'],
                ['Fixed term', 'Predictable payments'],
            ], [
                ['One predictable payment', 'A fixed rate and fixed term mean your payment does not change over the life of the loan.'],
                ['No collateral required', 'Unsecured borrowing, so no lien is placed on your home or vehicle.'],
                ['No origination surprises', 'All fees are disclosed in writing before you accept the loan.'],
                ['Direct deposit payoff', 'You can apply a portion of the proceeds to consolidate higher-rate balances.'],
            ], [
                ['What can I use a personal loan for?', 'Common uses include debt consolidation, home improvements, medical expenses, and major purchases.'],
                ['Is there a prepayment penalty?', 'There is no prepayment penalty on this loan.'],
            ], ['debt-consolidation', 'line-of-credit', 'home-loans', 'rates'], ['Personal Loans', 'Personal loan']),

            'debt-consolidation' => C::page('Loans', 'Loans', 'Debt Consolidation Loan', 'Replace several higher-rate balances with one fixed-rate payment.', [
                ['One payment', 'Instead of many'],
                ['Fixed', 'Rate for the term'],
                ['No collateral', 'Unsecured'],
                ['No penalty', 'Pay off early'],
            ], [
                ['Simplify your payments', 'A single monthly payment replaces several balances with different due dates.'],
                ['Borrow no more than needed', 'We size the loan to what you actually owe, not to the maximum you qualify for.'],
                ['No lien on your home', 'Consolidation loans are unsecured.'],
                ['Clear payoff timeline', 'Amortization is shown in full, so you know the end date and total cost.'],
            ], [
                ['Will consolidation hurt my credit?', 'Opening a new account adds a hard inquiry and a new credit line, which affects your score in the short term.'],
            ], ['personal-loans', 'line-of-credit', 'credit-cards', 'financial-tools'], ['Debt Consolidation', 'Debt consolidation', 'Consolidation']),

            'line-of-credit' => C::page('Loans', 'Loans', 'Line of Credit', 'A revolving credit limit you can draw on as needed and repay at your own pace.', [
                ['Revolving', 'Borrow as needed'],
                ['Variable', 'Rate can change'],
                ['No collateral', 'Unsecured'],
                ['Pay down', 'Lower the limit anytime'],
            ], [
                ['Draw only what you use', 'Interest accrues only on the balance you have outstanding.'],
                ['Flexible repayment', 'Pay down the balance and the credit line remains available.'],
                ['Request increases', 'Ask for a higher limit as your relationship grows.'],
                ['Manage online', 'View the balance, make payments, and draw from online banking.'],
            ], [
                ['What can I use a line of credit for?', 'It is commonly used for planned expenses, unexpected costs, or short-term liquidity needs.'],
            ], ['personal-loans', 'debt-consolidation', 'online-access', 'savings'], ['Line of Credit', 'Line of credit', 'Lines of Credit']),

            'student-loans' => C::page('Loans', 'Education', 'Student Loans', 'Federal and private financing options for undergraduate, graduate, and refinancing needs.', [
                ['Federal', 'And private options'],
                ['Fixed', 'And variable terms'],
                ['Deferment', 'Options while in school'],
                ['Refinance', 'Consolidate existing loans'],
            ], [
                ['Compare federal and private', 'Understand the differences in protections and repayment before you choose.'],
                ['In-school deferment', 'Payments can be deferred or reduced while you are enrolled at least half time.'],
                ['Repayment plans', 'Standard and graduated repayment plans are explained during application.'],
                ['Refinancing', 'Consolidate multiple education loans into a single new loan.'],
            ], [
                ['Should I choose a federal or private loan?', 'Federal loans carry specific protections that private loans do not. Consider both alongside your repayment timeline.'],
            ], ['education-funding', '529-plans', 'debt-consolidation', 'first-time-buyers'], ['Student Loans', 'Student loan', 'Student Loans']),

            'auto-loans' => C::page('Loans', 'Auto', 'Auto Loans', 'Financing for new and used vehicles with predictable fixed-rate payments.', [
                ['New & used', 'Vehicles covered'],
                ['Fixed', 'Rate for the term'],
                ['Fast', 'Online application'],
                ['Flexible', 'Early payoff allowed'],
            ], [
                ['New and used vehicles', 'Financing available for cars, trucks, and SUVs from participating dealers.'],
                ['Fixed-rate payments', 'Your payment stays the same for the full loan term.'],
                ['Refinance later', 'Refinance to a lower rate if your credit has improved since you bought.'],
                ['Online application', 'Apply in minutes and hear back about your rate.'],
            ], [
                ['Can I finance outside a dealer network?', 'Private-party financing is available for qualifying vehicles, subject to review.'],
            ], ['auto-refinance', 'rv-and-boat', 'line-of-credit', 'rates'], ['Auto Loans', 'Auto loan', 'Auto Loans']),

            'auto-refinance' => C::page('Loans', 'Auto', 'Auto Refinance', 'Replace an existing auto loan with a new one at a rate or term that fits you better.', [
                ['Rate', 'Potentially lower'],
                ['Fixed', 'Predictable payment'],
                ['No prepayment', 'Penalty on your old loan'],
                ['Fast', 'Online application'],
            ], [
                ['Compare your options', 'See your current rate beside the rate available to you today.'],
                ['No prepayment penalty', 'Refinance products from us carry no penalty for paying off early.'],
                ['Choose a new term', 'A longer term lowers the payment; a shorter term reduces total interest.'],
                ['No lien change needed', 'The lien stays on the vehicle through the refinance.'],
            ], [
                ['Will refinancing hurt my credit?', 'A new application requires a credit review, which has a small short-term effect on your score.'],
            ], ['auto-loans', 'rate-refinance', 'personal-loans', 'rates'], ['Auto Refinance', 'Auto refinance']),

            'rv-and-boat' => C::page('Loans', 'Auto', 'RV & Boat Loans', 'Fixed-rate financing for recreational vehicles, boats, and trailers.', [
                ['Recreational', 'RV, boat, trailer'],
                ['Fixed', 'Rate for the term'],
                ['Longer terms', 'Extended repayment'],
                ['Online', 'Fast application'],
            ], [
                ['Recreational vehicles', 'Financing for RVs, motorhomes, boats, and trailers.'],
                ['Longer repayment terms', 'Terms are structured for seasonal use and higher purchase prices.'],
                ['Fixed rates', 'Predictable payments for the full term.'],
                ['Private-party options', 'Financing available for boats and RVs purchased privately.'],
            ], [
                ['Do you finance boats kept at a marina?', 'Yes. Waterfront collateral is supported, subject to documentation.'],
            ], ['auto-loans', 'personal-loans', 'line-of-credit', 'rates'], ['RV & Boat', 'RV and boat', 'RV and Boat Loans']),

            'home-loans' => C::hub('Loans', 'Mortgages', 'Home Loans', 'Financing to buy a home, with programs for first-time buyers and veterans.', [
                ['Fixed-Rate Mortgage', 'Predictable payments.'],
                ['Adjustable-Rate Mortgage', 'Lower initial rate.'],
                ['FHA Loans', 'Low down payment options.'],
                ['VA Loans', 'For eligible veterans and service members.'],
            ], [
                ['How much can I afford?', 'Pre-qualification estimates a comfortable range without committing to a loan.'],
            ]),

            'mortgages' => C::hub('Loans', 'Mortgages', 'Mortgages', 'Home financing for purchase and refinance, across conventional and government-backed programs.', [
                ['Buy a home', 'Purchase financing.'],
                ['Refinance', 'Change rate or term.'],
                ['Government-backed', 'FHA and VA options.'],
                ['First-time buyers', 'Programs and guidance.'],
            ], [
                ['Do I need a down payment?', 'Conventional loans typically require a down payment. FHA and VA programs allow lower or no down payment.'],
            ]),

            'fixed-rate-mortgage' => C::page('Loans', 'Mortgages', 'Fixed-Rate Mortgage', 'The same rate and payment for the entire term, so your housing cost is predictable.', [
                ['Fixed', 'Rate for the full term'],
                ['15–30 yr', 'Typical terms'],
                ['Predictable', 'Monthly payment'],
                ['No rate risk', 'Payment never changes'],
            ], [
                ['Payment certainty', 'Your principal and interest payment does not change, regardless of market movement.'],
                ['Longer terms available', 'Choose a term that balances payment size against total interest.'],
                ['No annual rate resets', 'Unlike an adjustable-rate loan, there is no scheduled rate change.'],
                ['Assume the loan', 'Buyers may be able to assume an eligible existing loan.'],
            ], [
                ['Should I choose a 15- or 30-year term?', 'A shorter term means a higher payment and less total interest. A longer term lowers the payment and costs more overall.'],
            ], ['adjustable-rate-mortgage', 'pre-qualification', 'first-time-buyers', 'payment-calculator'], ['Fixed-Rate Mortgage', 'Fixed rate mortgage']),

            'adjustable-rate-mortgage' => C::page('Loans', 'Mortgages', 'Adjustable-Rate Mortgage', 'A lower starting rate that adjusts on a stated schedule, with caps to limit how much it can change.', [
                ['Lower start', 'Initial rate'],
                ['Caps', 'Limits on increases'],
                ['Adjustable', 'On a set schedule'],
                ['30 yr', 'Typical term'],
            ], [
                ['Lower initial payment', 'The starting rate is typically below the fixed-rate equivalent.'],
                ['Rate caps', 'Lifetime and periodic caps limit how much your rate can increase.'],
                ['Stated adjustment schedule', 'The reset frequency and index are disclosed before you sign.'],
                ['Refinance to fixed', 'Many borrowers refinance to a fixed rate once their budget allows.'],
            ], [
                ['What happens at reset?', 'The rate adjusts by the index plus a stated margin, subject to your caps.'],
            ], ['fixed-rate-mortgage', 'rate-lock', 'pre-qualification', 'rate-refinance'], ['Adjustable-Rate Mortgage', 'Adjustable-rate mortgage', 'ARM']),

            'fha-loans' => C::page('Loans', 'Mortgages', 'FHA Loans', 'Government-backed home financing with lower down payment requirements and built-in insurance.', [
                ['Low down', 'Reduced upfront'],
                ['Insured', 'Mortgage insurance included'],
                ['Credit-flexible', 'Broader qualification'],
                ['Fixed & ARM', 'Term options'],
            ], [
                ['Lower down payment', 'Reduced upfront cost compared with conventional financing.'],
                ['Mortgage insurance', 'Required insurance protects the lender, with your premium disclosed in writing.'],
                ['Broader credit profile', 'Designed to extend access to borrowers with limited credit history.'],
                ['Fixed and adjustable terms', 'Both structures are available.'],
            ], [
                ['Can I use an FHA loan more than once?', 'FHA financing is generally limited to one primary residence at a time.'],
            ], ['va-loans', 'first-time-buyers', 'pre-qualification', 'fixed-rate-mortgage'], ['FHA Loans', 'FHA loan', 'FHA Loans']),

            'va-loans' => C::page('Loans', 'Mortgages', 'VA Loans', 'Home financing for eligible veterans, active service members, and surviving spouses, with no down payment requirement.', [
                ['No down', 'Payment requirement'],
                ['No PMI', 'Monthly insurance'],
                ['Flexible', 'Eligibility'],
                ['Fixed & ARM', 'Term options'],
            ], [
                ['No down payment', 'Eligible borrowers can finance with no upfront payment.'],
                ['No monthly mortgage insurance', 'Eligible borrowers avoid a recurring mortgage insurance premium.'],
                ['Broad eligibility', 'Veterans, active service members, and some surviving spouses may qualify.'],
                ['Reasonable closing costs', 'Limits apply to which closing costs a buyer may pay.'],
            ], [
                ['How do I obtain a Certificate of Eligibility?', 'Our loan officers guide you through obtaining it, and the process is confirmed during underwriting.'],
            ], ['fha-loans', 'first-time-buyers', 'pre-qualification', 'fixed-rate-mortgage'], ['VA Loans', 'VA loan', 'VA Loans']),

            'mortgages' => C::hub('Loans', 'Mortgages', 'Refinance Your Mortgage', 'Replace your current loan to change your rate, term, or the loan itself.', [
                ['Rate refinance', 'Lower your rate.'],
                ['Cash-out refinance', 'Access equity.'],
                ['Streamlined refinance', 'Faster process.'],
                ['Compare options', 'See what you qualify for.'],
            ], [
                ['Is a refinance worth it?', 'Compare the new total interest against what remains on your current loan.'],
            ]),

            'rate-refinance' => C::page('Loans', 'Refinance', 'Rate Refinance', 'Replace your existing mortgage with a new loan at a lower rate and a new term.', [
                ['Lower rate', 'Potentially'],
                ['Fixed', 'Or adjustable'],
                ['No penalty', 'On our refinance loans'],
                ['Streamlined', 'Available options'],
            ], [
                ['See both rates side by side', 'Compare your current note rate with what you qualify for today.'],
                ['Choose a new term', 'Extend to lower the payment or shorten to reduce total interest.'],
                ['No prepayment penalty', 'Our refinance products carry no penalty for paying off early.'],
                ['Fixed-rate conversion', 'Move from an adjustable loan to a rate that will not reset.'],
            ], [
                ['How much can I save?', 'Savings depend on your balance, current rate, new rate, and the term you choose.'],
            ], ['cash-out-refinance', 'streamlined-refinance', 'fixed-rate-mortgage', 'payment-calculator'], ['Rate Refinance', 'Refinancing', 'Refinance']),

            'cash-out-refinance' => C::page('Loans', 'Refinance', 'Cash-Out Refinance', 'Refinance your mortgage and borrow against the equity in your home.', [
                ['Access equity', 'Cash at closing'],
                ['Fixed', 'Rate options'],
                ['Home stays', 'You keep living there'],
                ['Purpose documented', 'Clear underwriting'],
            ], [
                ['Equity becomes cash', 'Borrow against the value above your remaining balance.'],
                ['Keep the same property', 'You continue living in the home, with the new larger loan on the property.'],
                ['Fixed-rate options', 'Lock a rate that will not reset.'],
                ['Transparent underwriting', 'The permitted uses and documentation requirements are explained up front.'],
            ], [
                ['How much can I get?', 'It depends on your appraised value, remaining balance, and the maximum loan-to-value allowed.'],
            ], ['rate-refinance', 'personal-loans', 'payment-calculator', 'mortgages'], ['Cash-Out Refinance', 'Cash out refinance']),

            'streamlined-refinance' => C::page('Loans', 'Refinance', 'Streamlined Refinance', 'A faster refinance path for eligible borrowers who refinance a current loan with us.', [
                ['Simplified', 'Reduced documentation'],
                ['No appraisal', 'In some cases'],
                ['Faster', 'Shorter process'],
                ['Same property', 'Subject to review'],
            ], [
                ['Reduced documentation', 'Eligible borrowers may refinance without a full re-underwriting.'],
                ['No appraisal required', 'In qualifying cases, we use the existing property value.'],
                ['Shorter timeline', 'Less paperwork means a faster path to closing.'],
                ['Eligibility review', 'We confirm the current loan and borrower status before proceeding.'],
            ], [
                ['Am I eligible?', 'Eligibility depends on the current loan, its age, and documentation. We confirm this at application.'],
            ], ['rate-refinance', 'cash-out-refinance', 'fixed-rate-mortgage', 'pre-qualification'], ['Streamlined Refinance', 'Streamlined refinance']),

            'compare-mortgages' => C::hub('Loans', 'Compare', 'Compare Mortgage Options', 'Compare fixed, adjustable, and government-backed loans by rate, term, and cost.', [
                ['Fixed-rate', 'Payment certainty.'],
                ['Adjustable-rate', 'Lower initial rate.'],
                ['FHA and VA', 'Government-backed options.'],
            ], [
                ['Which costs less over time?', 'The loan with the lowest initial rate is not always the cheapest over its full term. Compare total interest.'],
            ], 'hub', ['Compare Options', 'Compare options', 'Compare Mortgage Options']),

            'first-time-buyers' => C::page('Loans', 'Mortgages', 'First-Time Home Buyers', 'Guidance, programs, and step-by-step help for your first home purchase.', [
                ['Guidance', 'Step-by-step'],
                ['Programs', 'Down payment help'],
                ['Pre-qualify', 'See your range'],
                ['Specialists', 'Local guidance'],
            ], [
                ['Understand the process', 'A step-by-step overview of pre-qualification, offers, escrow, and closing.'],
                ['Down payment assistance', 'We explain the assistance programs available in your area and how to apply.'],
                ['Budget guidance', 'A realistic budget avoids surprises and keeps your options open.'],
                ['Dedicated support', 'A loan officer walks with you from application to closing day.'],
            ], [
                ['How much should I save for a down payment?', 'Conventional loans typically require a down payment; government-backed loans can allow less or none.'],
            ], ['pre-qualification', 'fha-loans', 'va-loans', 'payment-calculator'], ['First-Time Buyers', 'First time buyers', 'First-Time Buyers']),

            'pre-qualification' => C::page('Loans', 'Mortgages', 'Mortgage Pre-Qualification', 'Find out roughly what you can afford without committing to a loan.', [
                ['Non-binding', 'No obligation'],
                ['Soft review', 'No hard credit pull'],
                ['Ballpark', 'Payment range'],
                ['Fast', 'Online application'],
            ], [
                ['See your range', 'Receive an estimated payment range based on your income, debts, and down payment.'],
                ['Soft credit review', 'Pre-qualification does not affect your credit score.'],
                ['Know your budget', 'Understanding the real number helps you shop with confidence.'],
                ['No obligation', 'You are not committing to a loan, and you can pre-qualify elsewhere too.'],
            ], [
                ['Is pre-qualification a promise to lend?', 'No. It is an estimate. Final approval happens after full underwriting.'],
            ], ['first-time-buyers', 'payment-calculator', 'rate-lock', 'home-loans'], ['Pre-Qualification', 'Pre-qualification', 'Pre qualification']),

            'rate-lock' => C::page('Loans', 'Mortgages', 'Rate Lock', 'Hold your mortgage rate steady while your loan moves from offer to closing.', [
                ['Locked', 'Rate held firm'],
                ['Stated period', 'Known duration'],
                ['Transparent', 'No hidden fees'],
                ['Renewal', 'Options explained'],
            ], [
                ['Protect your rate', 'A lock holds your rate steady while you finish the loan.'],
                ['Know the length', 'The lock period is stated in writing, so you can plan closing within it.'],
                ['Lock fee disclosed', 'Any lock fee is shown before the loan is created.'],
                ['Renewal options', 'If a purchase is delayed, renewal or extension options are explained up front.'],
            ], [
                ['What if my closing is delayed?', 'We discuss renewal or extension options before the current lock expires.'],
            ], ['fixed-rate-mortgage', 'pre-qualification', 'rate-refinance', 'compare-mortgages'], ['Rate Lock', 'Rate lock']),

            'business-loans' => C::page('Business', 'Business', 'Business Loans', 'Term loans and working capital financing for growing businesses.', [
                ['Term', 'Predictable payments'],
                ['Working capital', 'Short-term needs'],
                ['Fast', 'Online application'],
                ['Relationship', 'Dedicated banker'],
            ], [
                ['Working capital', 'Bridge timing gaps between expenses and customer payments.'],
                ['Growth financing', 'Fund equipment, expansion, or a second location.'],
                ['Predictable repayment', 'Fixed-term structures with scheduled payments.'],
                ['Dedicated banker', 'One point of contact who knows your business.'],
            ], [
                ['How long does approval take?', 'Timelines vary by product and documentation. We give you a clear view after your first conversation.'],
            ], ['equipment-financing', 'sba-loans', 'commercial-real-estate', 'business-checking'], ['Business Loans', 'Business loan', 'Business Loans']),

            'equipment-financing' => C::page('Business', 'Business', 'Equipment Financing', 'Fund machinery, vehicles, and technology with a loan structured around the asset.', [
                ['Asset-backed', 'Secured by equipment'],
                ['Longer terms', 'Match the asset life'],
                ['Fast', 'Quick decisioning'],
                ['Fixed', 'Predictable payments'],
            ], [
                ['Secured by the equipment', 'The financed asset secures the loan, which often supports competitive rates.'],
                ['Terms matched to useful life', 'Repayment terms are structured to align with how long the equipment is expected to last.'],
                ['New and used', 'Both new equipment and qualifying used equipment can be financed.'],
                ['Quick decisions', 'We move quickly on equipment purchases so you do not lose the deal.'],
            ], [
                ['Can I finance equipment from any vendor?', 'Yes. You may purchase from any vendor and finance the equipment afterward.'],
            ], ['business-loans', 'commercial-real-estate', 'sba-loans', 'line-of-credit'], ['Equipment Financing', 'Equipment finance', 'Equipment Financing']),

            'sba-loans' => C::page('Business', 'Business', 'SBA Loans', 'Financing for eligible small businesses through programs backed by the Small Business Administration.', [
                ['Program-backed', 'SBA lending'],
                ['Longer terms', 'Extended repayment'],
                ['Fixed', 'Rate options'],
                ['Guidance', 'Application help'],
            ], [
                ['Program guidance', 'We help you understand the requirements before you invest time in an application.'],
                ['Longer repayment terms', 'Longer terms keep payments manageable for a growing business.'],
                ['Fixed-rate options', 'Structure the loan around predictable payments.'],
                ['We work with you', 'Our team assembles the documentation so the process moves quickly.'],
            ], [
                ['Do I need to use a preferred lender?', 'No. Eligibility and program terms are explained to you regardless of lender.'],
            ], ['business-loans', 'equipment-financing', 'business-checking', 'community'], ['SBA Loans', 'SBA loan', 'SBA Loans']),

            'commercial-real-estate' => C::page('Business', 'Business', 'Commercial Real Estate Loans', 'Financing for property purchase, refinance, and construction.', [
                ['Purchase', 'And refinance'],
                ['Term loan', 'Fixed structures'],
                ['Relationship', 'Banker assigned'],
                ['Flexible', 'Amortization options'],
            ], [
                ['Property purchase and refinance', 'Finance an investment property or refinance an existing one.'],
                ['Fixed and floating structures', 'Terms matched to the property and your business cash flow.'],
                ['Amortization options', 'Choose payment structures that suit the property.'],
                ['Dedicated relationship banker', 'One contact across the life of the loan.'],
            ], [
                ['What types of properties qualify?', 'Office, retail, industrial, multifamily, and mixed-use properties are typically considered.'],
            ], ['equipment-financing', 'business-loans', 'international-banking', 'industry-solutions'], ['Commercial Real Estate', 'Commercial mortgage', 'Commercial Real Estate']),

        ];
    }
}
