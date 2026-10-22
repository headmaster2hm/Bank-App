<?php

namespace App\Support\Content;

use App\Support\MarketingCatalog as C;

class BankingContent
{
    /** @return array<string, array<string, mixed>> */
    public static function pages(): array
    {
        return [

            'banking' => C::hub('Banking', 'Personal Banking', 'Personal Banking', 'Checking, savings, and everyday money tools built to stay out of your way.', [
                ['Everyday Checking', 'A simple account for daily spending, direct deposit, and bill pay.'],
                ['Savings that grow', 'Competitive savings and money market options for short and long horizons.'],
                ['Cards', 'Debit for purchases, credit for building and protecting your score.'],
                ['Digital banking', 'Deposit, pay, transfer, and manage everything from one place.'],
            ], [
                ['Is there a minimum balance?', 'No minimum balance is required to open or maintain an everyday checking account.'],
                ['Can I open an account online?', 'Yes. Online enrollment takes a few minutes and requires a valid photo ID.'],
            ]),

            'checking' => C::page('Banking', 'Checking', 'Everyday Checking', 'A straightforward checking account for daily life, with no monthly maintenance fee and a debit card included.', [
                ['$0', 'Monthly maintenance fee'],
                ['Unlimited', 'Transactions per month'],
                ['$0', 'Minimum opening deposit'],
                ['24/7', 'Online and mobile access'],
            ], [
                ['Real-time notifications', 'Know the moment a transaction posts, from a purchase to a direct deposit.'],
                ['Bill pay and transfers', 'Schedule recurring payments and move money between your SecureBank accounts.'],
                ['Paperless statements', 'Statements arrive in your inbox, organized by month and downloadable any time.'],
                ['Overdraft protection', 'Opt in to sweep from savings or link an external account rather than paying a fee.'],
            ], [
                ['What counts as a transaction?', 'Debit card purchases, checks, electronic debits, and ATM withdrawals each count once.'],
                ['Is there a fee to open?', 'No opening deposit or monthly maintenance fee is required.'],
            ], ['savings', 'debit-cards', 'mobile-app', 'compare-checking'], ['Everyday Checking', 'Everyday checking account']),

            'premium-checking' => C::page('Banking', 'Checking', 'Premium Checking', 'A higher-yielding checking account for customers who keep a meaningful balance and want interest on it.', [
                ['Interest', 'Paid on your balance'],
                ['Lower fees', 'Waived at higher balances'],
                ['Concierge', 'Priority phone support'],
                ['ATM', 'Fee rebates included'],
            ], [
                ['Interest on checking', 'Eligible balances earn a stated APY, disclosed in the account agreement.'],
                ['Fee waivers', 'Monthly fees are reduced or waived when combined balances meet stated thresholds.'],
                ['Concierge line', 'Direct access to a specialist for account questions and travel needs.'],
                ['Relationship benefits', 'Enhanced pricing on lending and wealth products you already hold with us.'],
            ], [
                ['How is interest calculated?', 'Interest accrues on the daily balance and is credited monthly, as described in your account agreement.'],
                ['How do I qualify for fee waivers?', 'Waivers apply based on your combined balances across linked SecureBank accounts.'],
            ], ['checking', 'savings', 'high-yield-savings', 'private-banking'], ['Premium Checking'], 'product', 'Open an Account', 'register'),

            'student-checking' => C::page('Banking', 'Checking', 'Student Checking', 'Banking designed around a student budget, with no monthly fee while you are enrolled.', [
                ['$0', 'Monthly maintenance fee'],
                ['$0', 'Minimum opening deposit'],
                ['No fee', 'While enrolled and eligible'],
                ['24/7', 'Mobile banking access'],
            ], [
                ['No monthly fee', 'The maintenance fee is waived while you remain enrolled at an eligible institution.'],
                ['Low-balance cushion', 'No overdraft penalty if you stay within a modest overdraft buffer.'],
                ['Student discounts', 'Reduced pricing on loans and accounts that convert after graduation.'],
                ['Graduation conversion', 'Move to an everyday account without changing your account number.'],
            ], [
                ['How do I verify student status?', 'You confirm enrollment through our student verification partner during application.'],
                ['What happens after I graduate?', 'Your account converts automatically and any fee waiver ends, with 30 days notice.'],
            ], ['checking', 'student-loans', 'education-funding', 'savings'], ['Student Checking', 'Student checking account']),

            'compare-checking' => C::page('Banking', 'Checking', 'Compare Checking Accounts', 'Side-by-side comparison of our checking products so you can weigh fees, interest, and features directly.', [
                ['Compare', 'Features side by side'],
                ['No fee', 'Options available'],
                ['Same number', 'Switch without changing details'],
                ['Specialist', 'Help choosing'],
            ], [
                ['Clear fee schedule', 'Every account lists its maintenance fee, waiver conditions, and ATM terms up front.'],
                ['Switch without restarting', 'Moving between accounts keeps your account history and routing details.'],
                ['Guidance from people', 'Bankers can walk you through trade-offs if you would rather not compare alone.'],
            ], [
                ['Will I have to close my current account?', 'No. You can open a different product and close the original whenever you like.'],
            ], ['checking', 'premium-checking', 'student-checking', 'savings'], ['Compare Checking', 'Compare checking'], 'hub', 'Open an Account', 'register'),

            'savings' => C::page('Banking', 'Savings', 'Savings Accounts', 'Set money aside and let it earn interest, with access whenever you need it.', [
                ['Competitive', 'Interest rates'],
                ['$0', 'Minimum to open'],
                ['Any time', 'Access to your funds'],
                ['No fee', 'Monthly maintenance'],
            ], [
                ['Interest that compounds', 'Interest is credited to your account and begins earning, subject to your agreement.'],
                ['No monthly maintenance fee', 'Savings accounts carry no recurring charge for holding the account.'],
                ['Flexible transfers', 'Move money in and out without penalty schedules or tiered withdrawal limits.'],
                ['Goal tracking', 'Name your savings goals and track progress separately within one account.'],
            ], [
                ['Is my savings deposit insured?', 'Deposit insurance is a separate arrangement from the bank and does not apply to every product. Any coverage terms and limits are described in full in the Disclosures section.'],
                ['What is the difference from a money market account?', 'A money market typically requires a higher minimum balance in exchange for a variable rate.'],
            ], ['high-yield-savings', 'money-market', 'cds', 'retirement-planning'], ['Savings Accounts', 'Savings account', 'Savings']),

            'high-yield-savings' => C::page('Banking', 'Savings', 'High-Yield Savings', 'Our highest-rate savings option, with no minimum balance and no monthly fee.', [
                ['4.50%', 'Illustrative APY'],
                ['$0', 'Minimum balance'],
                ['$0', 'Monthly fee'],
                ['Variable', 'Rate can change'],
            ], [
                ['Top of our savings range', 'The highest stated rate we offer on personal savings balances.'],
                ['No minimum to earn', 'The stated rate applies to all balances, with no tiered minimum requirement.'],
                ['Same-day access', 'Funds are available to withdraw or transfer the same business day.'],
                ['Automatic transfers', 'Schedule recurring transfers from checking to build the balance automatically.'],
            ], [
                ['Is 4.50% guaranteed?', 'No. The rate is variable and can change at any time. Check the Rates page for the current figure.'],
                ['Are there withdrawal limits?', 'No. There are no tiered withdrawal limits on this account.'],
            ], ['savings', 'money-market', 'cds', 'rates'], ['High-Yield Savings', 'High yield savings'], 'product', 'Open an Account', 'register'),

            'money-market' => C::page('Banking', 'Savings', 'Money Market Account', 'A savings account that typically offers a higher rate in exchange for a larger minimum balance.', [
                ['Higher rate', 'For larger balances'],
                ['Tiered', 'Rates by balance tier'],
                ['$0', 'Monthly fee'],
                ['Limited', 'Monthly transfers'],
            ], [
                ['Tiered interest', 'Rates are structured by balance tier, disclosed in full on the Rates page.'],
                ['Higher yield potential', 'Designed for balances you can leave in place for a while.'],
                ['Monthly transfer allowance', 'A stated number of outgoing transfers per month keeps the account from becoming a transaction account.'],
                ['Easy to convert', 'Move to a high-yield savings account at any time without a closing fee.'],
            ], [
                ['How many transfers are allowed?', 'A stated monthly allowance applies. Exceeding it converts the account to a checking account.'],
            ], ['high-yield-savings', 'savings', 'cds', 'rates'], ['Money Market', 'Money market account']),

            'compare-savings' => C::page('Banking', 'Savings', 'Compare Savings Accounts', 'Compare our savings products by rate, minimum balance, and access.', [
                ['Compare', 'Rates side by side'],
                ['Clear terms', 'Full disclosures'],
                ['No fee', 'Switch anytime'],
                ['Guidance', 'Talk to a banker'],
            ], [
                ['Rates in one place', 'All current savings rates, tiers, and conditions appear on a single page.'],
                ['Minimums at a glance', 'See which products require a balance and which do not.'],
                ['Access compared', 'Understand withdrawal flexibility before you choose.'],
            ], [], ['savings', 'high-yield-savings', 'money-market', 'cds'], ['Compare Savings', 'Compare savings'], 'hub', 'Open an Account', 'register'),

            'cds' => C::page('Banking', 'Deposits', 'Certificates of Deposit', 'Lock in a fixed rate for a set term and earn a known return on your deposit.', [
                ['Fixed', 'Rate for the full term'],
                ['Terms', 'From short to multi-year'],
                ['$1,000', 'Typical minimum'],
                ['Disclosed', 'Early withdrawal terms'],
            ], [
                ['Predictable returns', 'Your rate is fixed for the entire term, so the interest you earn is known.'],
                ['Ranging terms', 'Choose a term that matches your timeline, from months to several years.'],
                ['Laddering', 'Stagger maturities so deposits come due on a schedule you choose.'],
                ['Early withdrawal disclosure', 'Terms for early withdrawal, including any penalty, are stated before you open.'],
            ], [
                ['What happens if I withdraw early?', 'Early withdrawal terms and any resulting penalty are described in your agreement.'],
                ['Is there a minimum?', 'Minimum balances vary by term and are listed on the Rates page.'],
            ], ['high-yield-savings', 'money-market', 'rates', 'savings'], ['Certificates of Deposit', 'CDs', 'CD', 'Certificate of Deposit']),

            'cds-and-iras' => C::page('Banking', 'Deposits', 'CDs & IRAs', 'Fixed-term deposits and retirement accounts, held together in one place.', [
                ['Fixed', 'CD terms'],
                ['Tax-advantaged', 'IRA options'],
                ['Variety', 'Term lengths'],
                ['One view', 'Combined balances'],
            ], [
                ['Certificates of deposit', 'Fixed-rate deposits across a range of terms and minimums.'],
                ['Traditional and Roth IRAs', 'Retirement accounts with different tax treatment, explained before you contribute.'],
                ['Combined balance view', 'See your deposits and retirement savings together in online banking.'],
                ['Automatic renewal choices', 'Choose whether matured CDs renew, and to which term.'],
            ], [
                ['Can I have both a Traditional and Roth IRA?', 'Yes. Contribution limits and eligibility rules for each are explained during enrollment.'],
            ], ['cds', 'iras', 'retirement-planning', 'savings'], ['CDs & IRAs', 'CDs and IRAs', 'Certificates of Deposit', 'IRAs']),

            'joint-accounts' => C::page('Banking', 'Accounts', 'Joint Accounts', 'An account you share with another person, with equal access and clear ownership.', [
                ['Shared', 'Two owners'],
                ['Equal', 'Access for both'],
                ['Clear', 'Ownership terms'],
                ['Flexible', 'Add or remove owners'],
            ], [
                ['Both owners have full access', 'Each owner can view balances, make payments, and manage the account.'],
                ['Clear survivorship terms', 'Ownership and what happens on death are documented in the agreement.'],
                ['Works with our other products', 'A joint account can fund savings goals and support bill pay.'],
                ['Straightforward changes', 'Adding or removing an owner requires the same identity verification as opening.'],
            ], [
                ['Does either owner owe tax on all the income?', 'Interest reporting depends on the account agreement and your tax situation. Ask a tax professional for advice.'],
            ], ['checking', 'savings', 'compare-accounts', 'estate-planning'], ['Joint Accounts', 'Joint account']),

            'checking-accounts' => C::hub('Banking', 'Accounts', 'Checking Accounts', 'Everyday deposit accounts for spending, direct deposit, and paying bills.', [
                ['Everyday Checking', 'No monthly fee, no minimum balance.'],
                ['Premium Checking', 'Interest and fee waivers for higher balances.'],
                ['Student Checking', 'No fee while you are enrolled.'],
        ], [
            ['How do I switch accounts?', 'Open the new account, move your balance and direct deposits, then close the original whenever you like.'],
        ]),

            'savings-accounts' => C::hub('Banking', 'Accounts', 'Compare Savings Products', 'Deposit accounts that earn interest and keep your money separate from daily spending.', [
                ['High-Yield Savings', 'Our highest savings rate with no minimum.'],
                ['Savings Accounts', 'Flexible saving with no monthly fee.'],
                ['Money Market', 'Higher rates for larger balances.'],
            ], [
                ['What rate will I earn?', 'Current rates appear on the Rates page and in your account agreement.'],
            ]),

            'compare-accounts' => C::hub('Banking', 'Accounts', 'Compare All Accounts', 'Every deposit account we offer, with fees, minimums, and rates in one table.', [
                ['Personal accounts', 'Checking, savings, and joint accounts.'],
                ['Business accounts', 'Accounts designed for operating cash flow.'],
                ['Nonprofit accounts', 'Accounts for qualifying organizations.'],
            ], [
                ['Is the comparison final?', 'Terms shown are summaries. The account agreement that you sign is the controlling document.'],
            ], 'hub', ['Compare Accounts', 'compare accounts', 'Compare All Accounts']),

            'online-banking' => C::page('Banking', 'Digital', 'Online Banking', 'Manage accounts, pay bills, transfer money, and deposit checks from any device.', [
                ['24/7', 'Account access'],
                ['Free', 'Standard online banking'],
                ['Secure', 'Multi-factor sign-in'],
                ['Paperless', 'E-statements'],
            ], [
                ['Transfers and payments', 'Move money between accounts and schedule bill payments with reminders.'],
                ['Remote deposit', 'Deposit a check by photographing it, with funds often available sooner.'],
                ['Alerts you choose', 'Set thresholds for balance, deposit, and withdrawal notifications.'],
                ['Statements and history', 'Search and download statements by date, up to several years.'],
            ], [
                ['Is online banking free?', 'Online and mobile banking are included with your account at no additional charge.'],
                ['What if I lose my phone?', 'Contact us to disable the app on your old device and re-enroll access on the new one.'],
            ], ['mobile-app', 'mobile-deposit', 'bill-pay', 'online-access'], ['Online Banking', 'Online banking']),

            'mobile-app' => C::page('Banking', 'Digital', 'Mobile Banking App', 'Banking built for your phone, with biometric sign-in and the features you use most.', [
                ['Biometric', 'Face and fingerprint sign-in'],
                ['Deposit', 'Check deposit by photo'],
                ['Alerts', 'Push notifications'],
                ['Free', 'No download cost'],
            ], [
                ['Sign in with biometrics', 'Use your device fingerprint or face recognition instead of typing a password.'],
                ['Deposit a check in seconds', 'Photograph the front and back of a check to submit it for review.'],
                ['Instant balance visibility', 'Balances and recent activity load automatically when you open the app.'],
                ['Card controls', 'Lock a card, report it lost, and set travel notices without calling us.'],
            ], [
                ['Which devices are supported?', 'Current and previous versions of major iOS and Android releases are supported.'],
                ['Is the app free?', 'Yes. The app is a free download and included with your account.'],
            ], ['online-banking', 'mobile-deposit', 'card-controls', 'security-center'], ['Mobile App', 'Mobile app', 'Download the App']),

            'mobile-deposit' => C::page('Banking', 'Digital', 'Mobile Deposit', 'Deposit a paper check without visiting a branch.', [
                ['Photo', 'Submit from your phone'],
                ['Limits', 'Stated daily and item limits'],
                ['Alerts', 'Status notifications'],
                ['24/7', 'Submit any time'],
            ], [
                ['Two photos, one submission', 'Capture the front and back of your check and confirm the amount.'],
                ['Clear availability guidance', 'Funds availability follows the same schedule as a branch deposit.'],
                ['Track your submission', 'Receive a notification when the deposit is received and again when it posts.'],
                ['Hold notices explained', 'If a deposit is on hold, the reason and expected release are shown to you.'],
            ], [
                ['How long until funds are available?', 'Availability follows the standard schedule described in your account agreement.'],
                ['What checks cannot be deposited this way?', 'Some third-party and foreign checks are not eligible for remote deposit.'],
            ], ['mobile-app', 'online-banking', 'find-a-branch', 'alerts'], ['Mobile Deposit', 'Mobile deposit']),

            'bill-pay' => C::page('Banking', 'Digital', 'Bill Pay', 'Schedule and monitor recurring payments so nothing is due on the same day.', [
                ['Payee', 'Pay from your account'],
                ['Schedule', 'One-time or recurring'],
                ['Alerts', 'Due-date reminders'],
                ['History', 'Confirmation records'],
            ], [
                ['Pay by payee', 'Add a company once and pay it on any schedule you like.'],
                ['Reminder before due date', 'Receive a notification ahead of each scheduled payment.'],
                ['Confirmation records', 'Every payment produces a confirmation you can reference later.'],
                ['Manage from any device', 'Schedule and cancel payments in online banking or the mobile app.'],
            ], [
                ['How far ahead can I schedule?', 'Payments can be scheduled well in advance, subject to the payee posting date.'],
            ], ['online-banking', 'mobile-app', 'alerts', 'checking'], ['Bill Pay', 'Bill pay']),

            'online-access' => C::page('Banking', 'Digital', 'Online Account Access', 'Everything you can do after signing in, in one reference.', [
                ['Balances', 'Real-time views'],
                ['Transfers', 'Between accounts'],
                ['Search', 'Full history'],
                ['Export', 'Download records'],
            ], [
                ['Balances and activity', 'See current balances and search transaction history by account, date, or amount.'],
                ['Transfers', 'Move money between your SecureBank accounts and set up recurring transfers.'],
                ['Statements', 'Download monthly, quarterly, or custom date-range statements.'],
                ['Profile and security', 'Update contact details, phone numbers, and sign-in settings.'],
            ], [], ['online-banking', 'mobile-app', 'statements', 'alerts'], ['Online Access', 'Online Access']),

            'statements' => C::page('Banking', 'Digital', 'Statements & Documents', 'Statements, notices, and tax documents, always available to download.', [
                ['Paperless', 'Default delivery'],
                ['Search', 'By date range'],
                ['Download', 'PDF statements'],
                ['Archive', 'Years of history'],
            ], [
                ['Monthly statements', 'Delivered electronically on the day they are generated.'],
                ['Custom date ranges', 'Request a statement covering any period you need for a record.'],
                ['Tax documents', 'Consolidated interest and tax summaries are published in one place.'],
                ['Delivery preferences', 'Choose electronic or mailed delivery and update it at any time.'],
            ], [
                ['How far back do statements go?', 'Several years of history is available in online banking.'],
            ], ['online-access', 'alerts', 'online-banking', 'tax-planning'], ['Statements', 'Statements', 'e-statements']),

            'alerts' => C::page('Banking', 'Digital', 'Account Alerts', 'Choose exactly which events notify you, and how you want to hear about them.', [
                ['Threshold', 'Balance triggers'],
                ['Real-time', 'Transaction alerts'],
                ['Channels', 'Email, SMS, push'],
                ['Control', 'Change anytime'],
            ], [
                ['Balance thresholds', 'Get notified when a balance crosses a number you choose.'],
                ['Transaction alerts', 'Real-time notice for purchases, deposits, withdrawals, and transfers.'],
                ['Sign-in alerts', 'Know when your account is accessed from a new device.'],
                ['Delivery channels', 'Route different alerts to email, text message, or app push.'],
            ], [
                ['Are alerts free?', 'Yes. Standard alerts are included with your account.'],
                ['What if I travel?', 'Add a travel notice so foreign or out-of-area activity is not flagged unexpectedly.'],
            ], ['online-access', 'security-center', 'mobile-app', 'statements'], ['Alerts', 'Alerts', 'Notifications']),

        ];
    }
}
