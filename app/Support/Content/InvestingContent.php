<?php

namespace App\Support\Content;

use App\Support\MarketingCatalog as C;

class InvestingContent
{
    /** @return array<string, array<string, mixed>> */
    public static function pages(): array
    {
        return [

            'investing' => C::hub('Investments', 'Investing', 'Investments', 'Self-directed accounts and advisory services for long-term wealth building.', [
                ['Brokerage Account', 'Trade stocks, ETFs, and funds.'],
                ['Robo-Advisor', 'Automated, advisor-guided investing.'],
                ['IRAs', 'Tax-advantaged retirement accounts.'],
                ['529 Plans', 'Education savings.'],
            ], [
                ['Investing involves risk', 'The value of investments can fall as well as rise. Nothing here is investment advice.'],
            ]),

            'brokerage-account' => C::page('Investments', 'Self-Directed', 'Brokerage Account', 'Trade and hold stocks, ETFs, mutual funds, and bonds in a taxable account.', [
                ['Taxable', 'Flexible account'],
                ['Stocks & ETFs', 'Full access'],
                ['Fractional', 'Investing options'],
                ['Online', 'Trade anywhere'],
            ], [
                ['Broad investment choice', 'Stocks, ETFs, mutual funds, and bonds in one account.'],
                ['Fractional investing', 'Own a portion of a share with a smaller initial investment.'],
                ['Research access', 'Screeners, watchlists, and portfolio tools in online banking.'],
                ['Transfer flexibility', 'Move positions in or out, subject to settlement timing.'],
            ], [
                ['Is a brokerage account insured?', 'Securities are not bank deposits and are not covered by deposit insurance.'],
                ['What are the fees?', 'Trading and account fees are disclosed in the pricing schedule before you open.'],
            ], ['robo-advisor', 'iras', 'mutual-funds', 'etfs'], ['Brokerage Account', 'Brokerage account', 'Brokerage']),

            'robo-advisor' => C::page('Investments', 'Advisory', 'Automated Advisor', 'Goal-based investing built and rebalanced for you, with a fiduciary standard and a stated all-in fee.', [
                ['Automated', 'Rebalanced for you'],
                ['Goal-based', 'Built around your plan'],
                ['Fiduciary', 'Held to your best interest'],
                ['All-in fee', 'No per-trade charges'],
            ], [
                ['You set the goal', 'Specify the goal, timeline, and risk level, and the strategy is constructed around them.'],
                ['Automatic rebalancing', 'Portfolios are rebalanced back to target as markets move.'],
                ['Tax-aware positioning', 'The strategy considers tax efficiency where it can.'],
                ['One all-in fee', 'A single stated annual fee with no per-trade commissions.'],
            ], [
                ['What does it cost?', 'A single stated annual fee, disclosed before you invest. No trading commissions.'],
                ['Can I withdraw at any time?', 'Yes. You can request withdrawal of your balance.'],
            ], ['brokerage-account', 'managed-portfolios', 'retirement-planning', 'financial-planning'], ['Robo-Advisor', 'Robo advisor', 'Automated Advisor']),

            'managed-portfolios' => C::page('Investments', 'Advisory', 'Managed Portfolios', 'Professionally managed portfolios built to your objectives, with a human advisor accountable to you.', [
                ['Managed', 'Professional management'],
                ['Rebalanced', 'On a schedule'],
                ['Fiduciary', 'Held to your best interest'],
                ['Reviewed', 'Regularly with your advisor'],
            ], [
                ['Professional management', 'Portfolios are constructed and maintained by investment professionals.'],
                ['Scheduled rebalancing', 'Allocation is reviewed and rebalanced to stay on target.'],
                ['Fiduciary care', 'Advice is held to your best interest, not a sales target.'],
                ['Regular reviews', 'Your advisor meets with you on a cadence you set.'],
            ], [
                ['What is the minimum to start?', 'Minimums are disclosed before you invest and vary by strategy.'],
            ], ['robo-advisor', 'private-banking', 'portfolio-review', 'alternative-investments'], ['Managed Portfolios', 'Managed portfolios']),

            'iras' => C::page('Investments', 'Retirement', 'Retirement Accounts (IRAs)', 'Tax-advantaged accounts for retirement savings, with contribution limits and rules explained clearly.', [
                ['Tax-advantaged', 'Retirement savings'],
                ['Traditional & Roth', 'Two structures'],
                ['2026 limit', 'Stated each year'],
                ['Flexible', 'Ongoing contributions'],
            ], [
                ['Traditional IRA', 'Contributions may be deductible depending on your income and filing status.'],
                ['Roth IRA', 'Contributions are after-tax, with qualified withdrawals generally tax-free.'],
                ['Contribute across the year', 'You can add to an IRA throughout the year, not just at year end.'],
                ['Rollovers', 'Move balances from a workplace plan or another IRA.'],
            ], [
                ['What is the contribution limit?', 'Annual limits are set by law and are published on the Rates and Planning pages each year.'],
                ['Can I have both an IRA and a workplace plan?', 'Yes, but the deductibility of IRA contributions may be limited when you are covered by a workplace plan.'],
            ], ['retirement-planning', '529-plans', 'brokerage-account', 'tax-planning'], ['IRAs', 'IRA', 'Retirement Accounts', 'Individual Retirement Accounts']),

            '529-plans' => C::page('Investments', 'Education', '529 Education Plans', 'Tax-advantaged savings plans for qualified education expenses.', [
                ['Tax-advantaged', 'Education savings'],
                ['Nationwide', 'Use at eligible schools'],
                ['Flexible', 'Change beneficiaries'],
                ['Family contributions', 'Anyone can contribute'],
            ], [
                ['Tax benefits', 'Earnings are generally exempt from tax when used for qualified education expenses.'],
                ['Nationwide use', 'Funds can be used at eligible educational institutions nationwide.'],
                ['Change beneficiaries', 'Update the designated beneficiary at any time.'],
                ['Anyone can contribute', 'Friends and family can contribute to the same plan.'],
            ], [
                ['What expenses qualify?', 'Qualified expenses include tuition, room and board, books, and certain equipment at eligible institutions.'],
            ], ['student-loans', 'education-funding', 'iras', 'financial-tools'], ['529 Plans', '529 plan', '529']),

            'mutual-funds' => C::page('Investments', 'Products', 'Mutual Funds', 'Diversified pooled portfolios available within brokerage and advisory accounts.', [
                ['Diversified', 'Pooled portfolios'],
                ['Families', 'By style and goal'],
                ['Disclosed fees', 'Expense ratios shown'],
                ['Professional', 'Fund managers'],
            ], [
                ['Instant diversification', 'A single purchase spreads money across many holdings.'],
                ['Options by strategy', 'Choose funds by investment objective, from broad index to targeted approaches.'],
                ['Disclosed costs', 'Expense ratios and any sales charges are shown before you invest.'],
                ['Professional management', 'Named managers run each portfolio within its stated mandate.'],
            ], [
                ['Are there load charges?', 'Some funds carry sales charges, which are disclosed on the fund page.'],
            ], ['etfs', 'bonds', 'brokerage-account', 'managed-portfolios'], ['Mutual Funds', 'Mutual fund', 'Mutual Funds']),

            'etfs' => C::page('Investments', 'Products', 'ETFs', 'Exchange-traded funds offering low-cost, index-based exposure you trade like a stock.', [
                ['Low cost', 'Typically lower expense ratios'],
                ['Trade anytime', 'Exchange-traded'],
                ['Diversified', 'Sector and index options'],
                ['Tax efficient', 'In-kind redemption available'],
            ], [
                ['Typically lower costs', 'ETFs often carry lower expense ratios than comparable actively managed funds.'],
                ['Trade during market hours', 'ETFs trade intraday, so you can act on pricing at any time the market is open.'],
                ['Broad and targeted', 'Choose broad market exposure or a specific sector.'],
                ['Tax efficiency', 'In-kind redemption can help manage capital gains taxes.'],
            ], [
                ['Are ETFs risk-free?', 'No. ETFs are investments whose value can fall as well as rise.'],
            ], ['mutual-funds', 'bonds', 'brokerage-account', 'retirement-planning'], ['ETFs', 'ETF', 'ETFs']),

            'bonds' => C::page('Investments', 'Products', 'Bonds & Fixed Income', 'Government and corporate fixed-income investments for income and portfolio ballast.', [
                ['Income', 'Coupon payments'],
                ['Government', 'Treasury and agency'],
                ['Corporate', 'Investment grade'],
                ['Diversify', 'Portfolio ballast'],
            ], [
                ['Coupon income', 'Many bonds pay periodic interest.'],
                ['Government securities', 'Treasury and agency securities are available.'],
                ['Corporate bonds', 'Investment-grade corporate issues across sectors.'],
                ['Portfolio ballast', 'Fixed income can reduce volatility relative to equities.'],
            ], [
                ['Why do bond prices fall when rates rise?', 'Bond prices and yields move in opposite directions. A rate rise generally lowers the price of an existing fixed-rate bond.'],
            ], ['etfs', 'mutual-funds', 'cds', 'tax-planning'], ['Bonds', 'Bond', 'Bonds']),

            'financial-planning' => C::page('Wealth', 'Planning', 'Financial Planning', 'A structured, goals-based review of where you are and what to do next.', [
                ['Goals-based', 'Built around your plan'],
                ['Comprehensive', 'Full financial picture'],
                ['Written', 'Actionable summary'],
                ['Reviewed', 'On a schedule'],
            ], [
                ['Full picture', 'We review cash flow, debts, protection, investments, and estate documents together.'],
                ['Prioritized actions', 'You leave with a ranked list, not a binder.'],
                ['Written summary', 'The plan is documented so you can act on it later.'],
                ['Scheduled reviews', 'Life changes. We review your plan on a cadence and after major events.'],
            ], [
                ['Is financial planning the same as investment advice?', 'They overlap but are not identical. Planning addresses your whole financial life.'],
            ], ['portfolio-review', 'retirement-planning', 'estate-planning', 'insurance-planning'], ['Financial Planning', 'Financial planning']),

            'portfolio-review' => C::page('Wealth', 'Planning', 'Portfolio Review', 'An independent look at your investments, allocation, costs, and tax efficiency.', [
                ['Independent', 'Objective review'],
                ['Allocation', 'Right-sized to your goal'],
                ['Costs', 'Fees examined'],
                ['Written', 'Findings and options'],
            ], [
                ['Objective assessment', 'We review what you hold against what your plan calls for.'],
                ['Cost analysis', 'Total expenses are examined so you know what you are paying.'],
                ['Tax considerations', 'Identify opportunities to improve tax efficiency.'],
                ['Documented findings', 'You receive a written summary of options.'],
            ], [
                ['Do I have to change my investments?', 'No. A review is informational. You decide what, if anything, to change.'],
            ], ['financial-planning', 'managed-portfolios', 'tax-planning', 'retirement-planning'], ['Portfolio Review', 'Portfolio review']),

            'retirement-planning' => C::page('Wealth', 'Planning', 'Retirement Planning', 'Model income, healthcare, and spending needs to build a retirement plan with confidence.', [
                ['Plan', 'Income modeling'],
                ['Healthcare', 'Cost planning'],
                ['Social Security', 'Claiming strategy'],
                ['Written', 'Actionable plan'],
            ], [
                ['Income modeling', 'Project portfolio drawdown alongside guaranteed income.'],
                ['Healthcare and long-term care', 'Estimate costs and explore coverage options.'],
                ['Social Security timing', 'Evaluate when to claim to coordinate with your portfolio.'],
                ['Actionable plan', 'Leave with a written plan and savings-rate targets.'],
            ], [
                ['How early should I start planning?', 'A decade or more out is the ideal window, but a plan helps at any stage.'],
            ], ['iras', 'financial-planning', 'estate-planning', '529-plans'], ['Retirement Planning', 'Retirement planning']),

            'education-funding' => C::page('Wealth', 'Planning', 'Education Funding', 'A plan for paying for college with a clear target and a savings path.', [
                ['Target', 'Clear cost estimate'],
                ['529', 'Tax-advantaged saving'],
                ['Timeline', 'Funding schedule'],
                ['Custom', 'Plan for multiple children'],
            ], [
                ['Estimate the target', 'Model projected tuition, room, and board at the schools you are considering.'],
                ['Choose the right vehicle', 'Tax-advantaged education accounts are compared to taxable saving.'],
                ['Build a schedule', 'Match contributions to a timeline so you are on track each year.'],
                ['Plan for multiple goals', 'We can help balance education funding with retirement saving.'],
            ], [
                ['How much should I save each year?', 'It depends on the target cost, time remaining, and assumed return. Our planner models it.'],
            ], ['529-plans', 'student-loans', 'financial-planning', 'retirement-planning'], ['Education Funding', 'Education funding']),

            'insurance-planning' => C::page('Wealth', 'Planning', 'Insurance Planning', 'Review your coverage so your protection matches your actual financial exposure.', [
                ['Review', 'Coverage gaps'],
                ['Life', 'Income replacement'],
                ['Disability', 'Income protection'],
                ['Plan', 'Documented summary'],
            ], [
                ['Coverage review', 'Examine life, disability, and long-term care coverage against your needs.'],
                ['Income replacement', 'Estimate how much income your family would need if you became unable to work.'],
                ['Beneficiary coordination', 'Align insurance and retirement beneficiaries.'],
                ['Documented plan', 'Receive a written summary and recommendations.'],
            ], [
                ['Do you sell insurance?', 'We review your existing coverage and refer specific coverage needs to licensed specialists.'],
            ], ['financial-planning', 'estate-planning', 'trust-services', 'tax-planning'], ['Insurance Planning', 'Insurance planning', 'Insurance']),

            'estate-planning' => C::page('Wealth', 'Planning', 'Estate Planning', 'Coordinate wills, trusts, and beneficiary designations so your wishes are documented.', [
                ['Documents', 'Wills and trusts'],
                ['Beneficiaries', 'Aligned across accounts'],
                ['Continuity', 'For minors and incapacity'],
                ['Reviewed', 'On a schedule'],
            ], [
                ['Document review', 'Existing wills and trusts are reviewed for gaps and outdated provisions.'],
                ['Beneficiary alignment', 'Retirement and insurance beneficiaries are checked for consistency.'],
                ['Continuity planning', 'Plans for minors, incapacity, and asset transfers.'],
                ['Regular review', 'Documents are revisited after major life changes.'],
            ], [
                ['Does this replace a lawyer?', 'No. Estate documents are typically drafted by an attorney. We help you prepare and coordinate.'],
            ], ['trust-services', 'financial-planning', 'private-banking', 'insurance-planning'], ['Estate Planning', 'Estate planning']),

            'tax-planning' => C::page('Wealth', 'Planning', 'Tax Strategy', 'Look for ways to keep more of what you earn through account type, timing, and location.', [
                ['Asset location', 'Right account types'],
                ['Tax-advantaged', 'Use the right accounts'],
                ['Timing', 'Year-end planning'],
                ['Coordination', 'With your tax professional'],
            ], [
                ['Asset location', 'Place tax-inefficient and tax-efficient holdings in appropriate accounts.'],
                ['Use the right accounts', 'Identify opportunities to use IRAs, 529 plans, and other advantaged vehicles.'],
                ['Year-end planning', 'Coordinate harvesting and contribution timing with your tax professional.'],
                ['Works alongside your advisor', 'We implement; your tax professional advises and files.'],
            ], [
                ['Do you file my taxes?', 'No. We provide investment and account strategy. A qualified tax professional handles filing.'],
            ], ['iras', 'portfolio-review', 'financial-planning', 'estate-planning'], ['Tax Strategy', 'Tax strategy', 'Tax Planning']),

            'private-banking' => C::page('Wealth', 'Wealth Management', 'Private Banking', 'Banking, lending, and advice for individuals with significant or complex financial lives.', [
                ['Dedicated', 'Named banker'],
                ['Banking & lending', 'Full-service'],
                ['Advisory', 'Wealth strategy'],
                ['Confidential', 'Discretionary service'],
            ], [
                ['A named banker', 'One person accountable for your day-to-day banking and lending.'],
                ['Custom lending', 'Credit lines sized to your balance and liquidity.'],
                ['Wealth coordination', 'Your banker works alongside your investment and planning teams.'],
                ['Discretionary service', 'We act within written authority limits you set.'],
            ], [
                ['What qualifies for private banking?', 'Eligibility is based on relationship balances and complexity. We confirm this in a conversation.'],
            ], ['trust-services', 'family-office', 'managed-portfolios', 'line-of-credit'], ['Private Banking', 'Private banking']),

            'trust-services' => C::page('Wealth', 'Wealth Management', 'Trust Services', 'Fiduciary administration of trusts and estates, administered to the terms of the document.', [
                ['Fiduciary', 'Documented administration'],
                ['Administered', 'To the trust terms'],
                ['Reporting', 'Regular statements'],
                ['Coordination', 'With your counsel'],
            ], [
                ['Fiduciary care', 'Assets are administered strictly according to the governing document.'],
                ['Regular reporting', 'Clear, periodic statements for beneficiaries and trustees.'],
                ['Tax coordination', 'We coordinate with tax professionals on filings.'],
                ['Works with your counsel', 'We collaborate with the attorney who drafted your documents.'],
            ], [
                ['What is a trustee responsible for?', 'A trustee manages trust assets for the benefit of the beneficiaries, following the trust document and applicable law.'],
            ], ['estate-planning', 'private-banking', 'family-office', 'philanthropy'], ['Trust Services', 'Trust services', 'Trust']),

            'family-office' => C::page('Wealth', 'Wealth Management', 'Family Office', 'Coordinated services for families managing wealth across generations.', [
                ['Multi-generational', 'Family coordination'],
                ['Consolidated', 'Full balance picture'],
                ['Planning', 'Across generations'],
                ['Education', 'Next-generation planning'],
            ], [
                ['Consolidated view', 'A single picture of accounts, loans, and investments across the family.'],
                ['Generational planning', 'Coordinate planning across parents, children, and grandchildren.'],
                ['Next-generation education', 'Prepare younger family members to manage wealth responsibly.'],
                ['Family governance', 'Help establish shared decision-making structures.'],
            ], [
                ['What is the minimum relationship?', 'Minimums are established with each family based on complexity and needs.'],
            ], ['private-banking', 'trust-services', 'philanthropy', 'financial-planning'], ['Family Office', 'Family office']),

            'philanthropy' => C::page('Wealth', 'Wealth Management', 'Philanthropic Planning', 'Give in a way that supports the causes you care about while supporting your family and tax goals.', [
                ['Charitable', 'Donor-advised funds'],
                ['Direct giving', 'Donor-directed gifts'],
                ['Tax-aware', 'Coordinate with your advisor'],
                ['Legacy', 'Family giving'],
            ], [
                ['Donor-advised funds', 'Contribute now, grant over time, and receive a deduction when you contribute.'],
                ['Direct gifts', 'Give directly to the charities you choose.'],
                ['Tax coordination', 'Plan giving alongside your overall tax picture.'],
                ['Family giving', 'Involve the next generation in your giving strategy.'],
            ], [
                ['Should I use a donor-advised fund?', 'It depends on when you want your deduction and how you want to manage grants. Your advisor can help you weigh it.'],
            ], ['trust-services', 'family-office', 'estate-planning', 'community'], ['Philanthropy', 'Philanthropy', 'Giving']),

            'alternative-investments' => C::page('Wealth', 'Wealth Management', 'Alternative Investments', 'Access to private markets and non-correlated strategies for qualified investors.', [
                ['Private markets', 'Beyond public markets'],
                ['Diversification', 'Non-correlated strategies'],
                ['Accredited', 'Qualified investors'],
                ['Illiquid', 'Long holding periods'],
            ], [
                ['Private equity and other private markets', 'Strategies generally unavailable in public markets.'],
                ['Illiquidity', 'These investments are not daily-liquid and are intended to be held for years.'],
                ['Qualification', 'Available to qualified and accredited investors.'],
                ['Diligence', 'We provide offering materials for your review.'],
            ], [
                ['Are these investments liquid?', 'No. They are illiquid by nature and are not intended for short-term cash needs.'],
                ['Am I qualified?', 'Access is limited to accredited or otherwise qualified investors.'],
            ], ['managed-portfolios', 'real-estate-investments', 'structured-products', 'private-banking'], ['Alternative Investments', 'Alternative investments']),

            'real-estate-investments' => C::page('Wealth', 'Wealth Management', 'Real Estate Investments', 'Real estate investment vehicles for qualified investors seeking property exposure.', [
                ['Property', 'Real estate exposure'],
                ['Diversified', 'Multiple properties'],
                ['Illiquid', 'Long holding periods'],
                ['Qualified', 'Investor requirements'],
            ], [
                ['Property exposure', 'Invest in diversified real estate without buying a property directly.'],
                ['Professional management', 'Properties are selected and managed by experienced sponsors.'],
                ['Illiquidity', 'Designed as a long-term holding, not short-term cash.'],
                ['Qualification', 'Available to qualified investors.'],
            ], [
                ['Are these liquid?', 'No. Real estate investments are illiquid and intended to be held for years.'],
            ], ['alternative-investments', 'structured-products', 'private-banking', 'portfolio-review'], ['Real Estate Investments', 'Real estate investments']),

            'structured-products' => C::page('Wealth', 'Wealth Management', 'Structured Products', 'Custom notes and structured investments designed around specific objectives.', [
                ['Custom', 'Designed to your goals'],
                ['Principal-linked', 'Defined downside'],
                ['Sophisticated', 'Qualified investors'],
                ['Documented', 'Full terms disclosed'],
            ], [
                ['Tailored payoff profiles', 'Returns are tied to an underlying index with defined terms.'],
                ['Principal-linked structures', 'Some structures seek to return principal at maturity, subject to issuer credit.'],
                ['Full term sheet', 'All terms, fees, and risks are documented before you invest.'],
                ['Sophisticated investors', 'Available to qualified investors only.'],
            ], [
                ['What are the risks?', 'These are complex, illiquid investments with issuer credit risk and limited liquidity. Read the term sheet carefully.'],
            ], ['alternative-investments', 'managed-portfolios', 'private-banking', 'portfolio-review'], ['Structured Products', 'Structured products']),

        ];
    }
}
