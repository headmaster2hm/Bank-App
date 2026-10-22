<?php

namespace App\Support\Content;

use App\Support\MarketingCatalog as C;

class CompanyContent
{
    /** @return array<string, array<string, mixed>> */
    public static function pages(): array
    {
        return [

            'about' => C::page('Company', 'About Us', 'About SecureBank', 'A bank built on clear terms, plain language, and long-term relationships.', [
                ['Clarity', 'Plain-language disclosures'],
                ['Advice', 'Guidance, not pressure'],
                ['Security', 'Layered protection'],
                ['Community', 'Local investment'],
            ], [
                ['Plain language', 'We publish terms and fees in language people can actually read.'],
                ['Guidance over pressure', 'We would rather help you choose the right product than the biggest one.'],
                ['Built to last', 'We are structured for stability, so your deposits are there when you need them.'],
                ['Local focus', 'We invest in the communities where we operate.'],
            ], [
                ['Are you a real bank?', 'This site is a demonstration prototype. Institution details, licensing, and regulatory status would be published in the Disclosures section for a real institution.'],
            ], ['careers', 'sustainability', 'newsroom', 'community'], ['About Us', 'About us', 'About', 'About Us']),

            'careers' => C::page('Company', 'Careers', 'Careers', 'Build your career at an institution that invests in people, not just hires them.', [
                ['Culture', 'Collegial'],
                ['Growth', 'Development programs'],
                ['Impact', 'Meaningful work'],
                ['Benefits', 'Comprehensive'],
            ], [
                ['Development', 'Structured paths and mentoring to grow your career.'],
                ['Community impact', 'Work that serves real clients and communities.'],
                ['Collaborative teams', 'A culture that values expertise shared across teams.'],
                ['Total rewards', 'Benefits and compensation designed to support long-term careers.'],
            ], [
                ['Do you have remote roles?', 'Remote and hybrid availability varies by team and is listed on each posting.'],
            ], ['about', 'community', 'sustainability', 'contact-us'], ['Careers', 'Careers', 'Career']),

            'investor-relations' => C::page('Company', 'Investor Relations', 'Investor Relations', 'Financial information, regulatory filings, and governance for our shareholders.', [
                ['Filings', 'Regulatory reports'],
                ['Governance', 'Board and policies'],
                ['Results', 'Financial results'],
                ['Transparency', 'Disclosure'],
            ], [
                ['Regulatory filings', 'Our periodic reports are filed with the appropriate regulators.'],
                ['Governance', 'Board composition, committee charters, and governance policies.'],
                ['Financial results', 'Quarterly and annual results are published as they are released.'],
                ['Disclosure', 'Material information is disclosed in a timely manner.'],
            ], [
                ['Where are your filings?', 'A real institution publishes its filings here. In this prototype, the Disclosures page lists the categories of documents that would appear.'],
            ], ['about', 'newsroom', 'disclosures', 'institution-details'], ['Investor Relations', 'Investor relations']),

            'newsroom' => C::hub('Company', 'Newsroom', 'Newsroom', 'Announcements, press releases, and media resources.', [
                ['Announcements', 'Company news'],
                ['Media', 'Press resources'],
                ['Insights', 'Perspectives on markets and planning.'],
            ], [
                ['How do I reach media?', 'Media inquiries can be directed through the Contact page.'],
            ]),

            'news' => C::hub('Company', 'News', 'Latest News', 'Recent announcements and updates from SecureBank.', [
                ['Company', 'Corporate announcements.'],
                ['Products', 'Product and service updates.'],
                ['Community', 'Community investment news.'],
            ], []),

            'insights' => C::hub('Company', 'Insights', 'Insights & Education', 'Practical guidance on saving, borrowing, investing, and planning.', [
                ['Banking basics', 'Everyday money management.'],
                ['Borrowing', 'Loans and credit.'],
                ['Investing', 'Markets and long-term growth.'],
                ['Planning', 'Life events and goals.'],
            ], [
                ['Is this financial advice?', 'No. These are educational articles, not advice tailored to your situation.'],
            ]),

            'insight-saving' => C::page('Company', 'Insights', 'Building an Emergency Fund', 'Why a cash buffer matters and how to build one that fits your budget.', [
                ['3–6 months', 'Common guideline'],
                ['Starter', 'Start small'],
                ['Automated', 'Build consistently'],
                ['Accessible', 'Keep it liquid'],
            ], [
                ['Why it matters', 'An emergency fund absorbs surprises without forcing debt or missed bills.'],
                ['Start small', 'Even modest automatic transfers build the habit quickly.'],
                ['Keep it accessible', 'Hold it somewhere you can reach it without penalty.'],
                ['Replenish it', 'Treat it as a first call when you use it.'],
            ], [], ['savings', 'budget-planner', 'financial-tools', 'savings-goal-calculator'], ['Building an Emergency Fund']),

            'insight-credit' => C::page('Company', 'Insights', 'Understanding Your Credit Score', 'What your score measures, what changes it, and how to read a report.', [
                ['Payment history', 'Largest factor'],
                ['Utilization', 'Keep it low'],
                ['Length', 'Time in account'],
                ['Free reports', 'Check annually'],
            ], [
                ['Payment history', 'Consistent on-time payments matter most.'],
                ['Credit utilization', 'Using a smaller share of your available credit can help.'],
                ['Age of accounts', 'Older accounts generally help your score.'],
                ['Check your reports', 'You can review your credit reports for free each year.'],
            ], [], ['credit-cards', 'debt-consolidation', 'financial-tools', 'cash-back-card'], ['Understanding Your Credit Score']),

            'insight-home' => C::page('Company', 'Insights', 'Saving for a Down Payment', 'Practical steps to turn a savings goal into a purchase.', [
                ['Target', 'Know the number'],
                ['Automate', 'Set it and forget it'],
                ['Accelerate', 'Temporary boosts'],
                ['Plan', 'Timeline'],
            ], [
                ['Know the target', 'Estimate the full cost, including closing and moving expenses.'],
                ['Automate transfers', 'Consistency beats size.'],
                ['Temporary boosts', 'Tax refunds and bonuses can accelerate the timeline.'],
                ['Plan the timeline', 'Work backward from a target purchase date.'],
            ], [], ['first-time-buyers', 'payment-calculator', 'savings', 'home-loans'], ['Saving for a Down Payment']),

            'community' => C::page('Company', 'Community', 'Community Impact', 'Investing in the communities we serve through grants, education, and small-business lending.', [
                ['Grants', 'Local nonprofits'],
                ['Education', 'Financial workshops'],
                ['Small business', 'Credit and guidance'],
                ['Volunteer', 'Employee-led'],
            ], [
                ['Community grants', 'Funding for local nonprofit and civic organizations.'],
                ['Financial education', 'Free workshops and one-on-one coaching for people in our communities.'],
                ['Small-business lending', 'Credit and guidance for local business owners.'],
                ['Employee volunteering', 'Our people volunteer their time alongside these programs.'],
            ], [
                ['How can my organization apply?', 'Nonprofit organizations can contact us to discuss the application process.'],
            ], ['sustainability', 'nonprofit-accounts', 'careers', 'about'], ['Community', 'Community Impact', 'Community Impact']),

            'sustainability' => C::page('Company', 'Sustainability', 'Sustainability', 'Reducing our environmental footprint and supporting a more sustainable economy.', [
                ['Operations', 'Lower footprint'],
                ['Financing', 'Sustainable projects'],
                ['Communities', 'Local resilience'],
                ['Reporting', 'Transparent progress'],
            ], [
                ['Operations', 'Efforts to reduce the environmental impact of our own operations.'],
                ['Sustainable financing', 'Financing for projects that benefit the environment.'],
                ['Community resilience', 'Supporting preparedness and local resilience.'],
                ['Transparent progress', 'We publish progress and set goals.'],
            ], [
                ['Do you publish a sustainability report?', 'A real institution would publish its goals and progress here. This prototype outlines the categories that would appear.'],
            ], ['community', 'business-banking', 'about', 'newsroom'], ['Sustainability', 'Sustainability']),

        ];
    }
}
