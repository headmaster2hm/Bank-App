<?php

namespace App\Support\Content;

use App\Support\MarketingCatalog as C;

class ToolsContent
{
    /** @return array<string, array<string, mixed>> */
    public static function pages(): array
    {
        return $common = [

            'financial-tools' => C::hub('Tools', 'Tools', 'Financial Tools & Calculators', 'Estimators and planners to help you explore what is possible before you commit.', [
                ['Mortgage calculator', 'Estimate a monthly payment.'],
                ['Savings goal planner', 'Work out what to save monthly.'],
                ['Retirement planner', 'Project your income needs.'],
                ['Auto loan estimator', 'Compare term lengths.'],
                ['Debt payoff calculator', 'Compare two ways to clear balances.'],
                ['Currency converter', 'Check a rate before you travel.'],
            ], [
                ['Are these estimates?', 'Yes. Every calculator is an estimate for planning, not a quote or a guarantee.'],
            ]),

            'rates' => C::page('Tools', 'Rates', 'Current Rates', 'Deposit and lending rates in one place, with terms and conditions stated alongside them.', [
                ['All rates', 'One page'],
                ['Terms', 'Stated clearly'],
                ['Tiers', 'Where applicable'],
                ['Disclaimer', 'Rates can change'],
            ], [
                ['Savings and deposit rates', 'Rates on savings, money market, and certificate accounts.'],
                ['Lending rates', 'Representative rates and APRs for loans and lines of credit.'],
                ['Balance tiers', 'Products with tiers show each tier and its minimum.'],
                ['Conditions', 'Terms, minimums, and conditions are stated with each rate.'],
            ], [
                ['How often do rates change?', 'Savings and money market rates are variable and can change at any time. Loan rates are fixed once your loan is created.'],
                ['Are these guaranteed?', 'No. Published rates are subject to change. The rate in your agreement is the one that applies to your account.'],
            ], ['high-yield-savings', 'money-market', 'cds', 'auto-loans'], ['Current Rates', 'Rates', 'View All Rates', 'rates']),

            'rate-calculator' => C::page('Tools', 'Rates', 'Rate Calculator', 'Estimate a rate or payment for a loan before you apply.', [
                ['Estimate', 'Plan before applying'],
                ['Private', 'Nothing is submitted'],
                ['Compare', 'Side by side options'],
                ['No impact', 'No credit pull'],
            ], [
                ['Enter loan details', 'Amount, term, and rate to estimate a payment.'],
                ['Compare terms', 'See how a different term changes the payment and total interest.'],
                ['No application required', 'Calculators are informational and do not submit anything.'],
                ['No credit impact', 'Using a calculator does not affect your credit.'],
            ], [
                ['Does using this affect my credit?', 'No. Calculators are estimates only and involve no credit review.'],
            ], ['rates', 'payment-calculator', 'auto-loan-calculator', 'mortgage-calculator'], ['Rate Calculator', 'Rate calculator']),

            'mortgage-calculator' => C::page('Tools', 'Calculators', 'Mortgage Calculator', 'Estimate your monthly payment and see how price, rate, and term change the total cost.', [
                ['Payment', 'Monthly estimate'],
                ['Breakdown', 'Principal vs. interest'],
                ['Compare', 'Term and down payment'],
                ['Planning', 'Estimate only'],
            ], [
                ['Monthly payment estimate', 'See principal and interest based on loan amount, rate, and term.'],
                ['Down payment scenarios', 'Compare how a larger down payment changes the loan amount.'],
                ['Term comparison', 'See how a shorter term lowers total interest but raises the payment.'],
                ['Estimate, not a quote', 'Actual terms depend on credit, down payment, and market conditions.'],
            ], [
                ['How accurate is this?', 'It is an estimate that excludes taxes, insurance, and fees. It is a planning tool, not a loan quote.'],
            ], ['payment-calculator', 'pre-qualification', 'fixed-rate-mortgage', 'financial-tools'], ['Mortgage Calculator', 'Mortgage calculator', 'Calculate Your Payment']),

            'payment-calculator' => C::page('Tools', 'Calculators', 'Loan Payment Calculator', 'Work out a monthly payment for a loan, a line of credit, or any scheduled debt.', [
                ['Any loan', 'Flexible input'],
                ['Breakdown', 'Interest vs. principal'],
                ['Amortization', 'See the full schedule'],
                ['Planning', 'Estimate only'],
            ], [
                ['Flexible inputs', 'Enter amount, annual rate, and term for any type of loan.'],
                ['Payment breakdown', 'See how much of each payment is principal and how much is interest.'],
                ['Full amortization', 'View the complete repayment schedule.'],
                ['Compare terms', 'Test different terms side by side.'],
            ], [
                ['What is excluded?', 'Calculators exclude taxes, insurance, and fees unless you add them.'],
            ], ['mortgage-calculator', 'auto-loan-calculator', 'debt-consolidation', 'financial-tools'], ['Loan Payment Calculator', 'Payment calculator', 'Calculate']),

            'auto-loan-calculator' => C::page('Tools', 'Calculators', 'Auto Loan Calculator', 'Estimate a car payment and see how term and down payment change it.', [
                ['Estimate', 'Monthly payment'],
                ['Terms', 'Compare lengths'],
                ['Trade-off', 'Payment vs. interest'],
                ['Plan', 'Budget ahead'],
            ], [
                ['Payment estimate', 'Enter price, down payment, rate, and term.'],
                ['Compare terms', 'See how a longer term lowers the payment but raises total interest.'],
                ['Down payment scenarios', 'Test how more upfront reduces the loan.'],
                ['Budget planning', 'Use the estimate to see what fits your monthly budget.'],
            ], [
                ['Does this affect my credit?', 'No. This is an estimate and involves no credit review.'],
            ], ['auto-loans', 'payment-calculator', 'auto-refinance', 'financial-tools'], ['Auto Loan Calculator', 'Auto loan calculator']),

            'savings-goal-calculator' => C::page('Tools', 'Calculators', 'Savings Goal Calculator', 'Work out what to set aside each month to reach a goal on time.', [
                ['Target', 'Set a goal'],
                ['Monthly', 'What to set aside'],
                ['Timeline', 'Reach it by when'],
                ['Adjust', 'Change variables'],
            ], [
                ['Set your target', 'Enter the amount you need and the date you need it.'],
                ['Monthly contribution', 'See what to set aside each month to get there.'],
                ['Compare timelines', 'A later date usually means a smaller monthly amount.'],
                ['Adjust as you go', 'Change assumptions to see the impact.'],
            ], [
                ['What return does it assume?', 'You can set an assumed return. Lower assumptions show larger required contributions.'],
            ], ['savings', 'high-yield-savings', '529-plans', 'financial-tools'], ['Savings Goal Calculator', 'Savings calculator', 'Savings Goal Calculator']),

            'cd-calculator' => C::page('Tools', 'Calculators', 'CD Ladder Calculator', 'See how staggering certificate maturities can give you both returns and access.', [
                ['Ladder', 'Stagger maturities'],
                ['Access', 'Funds come due'],
                ['Returns', 'Compare terms'],
                ['Plan', 'Plan cash flow'],
            ], [
                ['Build a ladder', 'Split a balance across CDs with staggered maturity dates.'],
                ['Planned access', 'See when each portion comes due.'],
                ['Compare approaches', 'Contrast a ladder with a single certificate.'],
                ['Match your timeline', 'Size the ladder to when you expect to need the money.'],
            ], [
                ['What is the downside of a CD ladder?', 'Some portions are locked at lower rates while others mature at current rates.'],
            ], ['cds', 'high-yield-savings', 'rates', 'financial-tools'], ['CD Ladder Calculator', 'CD calculator', 'CD Calculator']),

            'retirement-planner' => C::page('Tools', 'Planning', 'Retirement Planner', 'Estimate whether your savings rate and plan could support the retirement you want.', [
                ['Estimate', 'Projected need'],
                ['Savings rate', 'Required contributions'],
                ['Timeline', 'Your target date'],
                ['Adjust', 'Test scenarios'],
            ], [
                ['Estimate your need', 'Model annual spending in retirement and adjust for inflation.'],
                ['Savings rate', 'See the contribution rate that supports your target.'],
                ['Income sources', 'Factor in Social Security and other income.'],
                ['Scenario planning', 'Change assumptions to see how sensitive the plan is.'],
            ], [
                ['Is this financial advice?', 'No. It is an educational estimate. Retirement planning is complex; consider a fee-only advisor for advice tailored to you.'],
            ], ['retirement-planning', 'iras', 'financial-tools', 'portfolio-review'], ['Retirement Planner', 'Retirement planner', 'Retirement Calculator']),

            'budget-planner' => C::page('Tools', 'Planning', 'Budget Planner', 'Organize income and expenses into a plan you can actually follow.', [
                ['Categories', 'Income and expenses'],
                ['Targets', 'Set limits'],
                ['Track', 'See progress'],
                ['Private', 'Stays in your browser'],
            ], [
                ['Categorize income and expenses', 'Group spending into categories that reflect how you actually spend.'],
                ['Set targets', 'Give each category a monthly limit.'],
                ['Track progress', 'Compare actual spending against targets.'],
                ['Your data stays with you', 'Planners run in your browser and are not sent to us.'],
            ], [
                ['Is my budget data saved?', 'No. The planner runs locally in your browser. Nothing is transmitted or stored on our servers.'],
            ], ['financial-tools', 'savings', 'insight-saving', 'online-banking'], ['Budget Planner', 'Budget planner', 'Budget Tracker']),

            'investment-growth' => C::page('Tools', 'Planning', 'Investment Growth Projection', 'See how contributions and market returns could compound over time.', [
                ['Compound', 'Long-term growth'],
                ['Adjust', 'Contribution and return'],
                ['Compare', 'Different horizons'],
                ['Educational', 'Not advice'],
            ], [
                ['See compounding', 'Watch regular contributions grow over a long horizon.'],
                ['Adjust assumptions', 'Change your contribution amount and assumed return.'],
                ['Compare timelines', 'Contrast starting now with starting later.'],
                ['Understand the range', 'Returns vary, so treat this as a range rather than a promise.'],
            ], [
                ['Are these projections guaranteed?', 'No. Markets can go down as well as up. Treat this as an educational illustration, not a prediction or advice.'],
            ], ['brokerage-account', 'iras', 'retirement-planner', 'financial-tools'], ['Investment Growth Projection', 'Investment projection', 'Investment Growth']),

            'net-worth-calculator' => C::page('Tools', 'Planning', 'Net Worth Calculator', 'Tally what you own and owe to get a clear financial snapshot.', [
                ['Assets', 'What you own'],
                ['Liabilities', 'What you owe'],
                ['Snapshot', 'Net worth'],
                ['Private', 'Runs in your browser'],
            ], [
                ['List your assets', 'Cash, investments, property, and vehicles.'],
                ['List your liabilities', 'Mortgages, loans, and credit balances.'],
                ['See net worth', 'Assets minus liabilities gives your current position.'],
                ['Track over time', 'Save a copy each year to see your progress.'],
            ], [
                ['Is my information stored?', 'No. The calculator runs locally in your browser. Nothing is sent to us.'],
            ], ['financial-tools', 'portfolio-review', 'budget-planner', 'online-access'], ['Net Worth Calculator', 'Net worth calculator', 'Net Worth']),

            'debt-payoff-calculator' => C::page('Tools', 'Calculators', 'Debt Payoff Calculator', 'Compare paying balances down faster against a steady monthly payment.', [
                ['Compare', 'Two strategies'],
                ['Interest', 'Projected savings'],
                ['Timeline', 'Months to zero'],
                ['Educational', 'Not advice'],
            ], [
                ['Avalanche method', 'Direct extra payments at the balance with the highest interest rate.'],
                ['Snowball method', 'Clear the smallest balance first for quicker visible progress.'],
                ['See the interest difference', 'Compare the total interest each approach would cost.'],
                ['Adjust the plan', 'Change your payment and extra contribution to see the effect.'],
            ], [
                ['Which method is better?', 'The avalanche method generally costs less in total interest. The snowball method can be easier to stick with. Most people do better with a plan they keep.'],
                ['Is this financial advice?', 'No. It is an educational estimate. A payoff plan also depends on fees and changes to your balances.'],
            ], ['debt-consolidation', 'credit-cards', 'financial-tools', 'line-of-credit'], ['Debt Payoff Calculator', 'Debt payoff calculator', 'Debt Payoff']),

            'currency-converter' => C::page('Tools', 'Calculators', 'Currency Converter', 'Convert amounts between currencies for travel and budgeting reference.', [
                ['Convert', 'Many currencies'],
                ['Reference', 'Indicative rates'],
                ['Offline', 'Runs in your browser'],
                ['Private', 'No data sent'],
            ], [
                ['Pick a currency', 'Select the currency you are converting from and the one you need.'],
                ['Use an indicative rate', 'Rates are for reference and change continuously through the day.'],
                ['Budget before you travel', 'Check what a trip or purchase will cost before you commit to it.'],
                ['Check card rates at purchase', 'If your card charges a foreign transaction fee, the final amount will differ.'],
            ], [
                ['Are these exchange rates guaranteed?', 'No. Currency markets move continuously. The rate you receive is set at the time of conversion, not the rate shown here.'],
                ['Why does my card cost more?', 'Cards may add a foreign transaction fee or a rate difference from the midpoint shown here.'],
            ], ['credit-cards', 'currency-converter', 'financial-tools', 'travel-rewards-card'], ['Currency Converter', 'Currency converter', 'Currency Conversion']),

        ];
    }
}
