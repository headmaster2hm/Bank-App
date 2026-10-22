<?php

namespace App\Support\Content;

use App\Support\MarketingCatalog as C;

class SupportContent
{
    /** @return array<string, array<string, mixed>> */
    public static function pages(): array
    {
        return [

            'help-support' => C::hub('Support', 'Support', 'Help & Support', 'Get answers, reach a person, or report something that does not look right.', [
                ['Help Center', 'Answers to common questions.'],
                ['Contact Us', 'Reach us by phone or online.'],
                ['Security Center', 'Protect your accounts.'],
                ['Find a Branch', 'Locations and hours.'],
            ], [
                ['How fast can I reach someone?', 'Phone and secure message response times vary by channel. Live chat is typically the fastest for simple questions.'],
            ]),

            'help-center' => C::page('Support', 'Support', 'Help Center', 'Guides and answers for account setup, transactions, and troubleshooting.', [
                ['Guides', 'Step-by-step help'],
                ['Search', 'Find answers fast'],
                ['Contact', 'Escalate to a person'],
                ['24/7', 'Digital access'],
            ], [
                ['Account help', 'Open, close, and update your accounts.'],
                ['Transaction help', 'Understand a charge, transfer, or deposit on your statement.'],
                ['Troubleshooting', 'Resolve common sign-in and access issues.'],
                ['Escalate', 'Connect with a person when self-service does not solve it.'],
            ], [], ['contact-us', 'security-center', 'report-fraud', 'enroll-online-banking'], ['Help Center', 'Help center']),

            'contact-us' => C::page('Support', 'Support', 'Contact Us', 'Reach us by phone, secure message, or live chat, whichever fits the situation.', [
                ['Phone', 'Speak to a specialist'],
                ['Secure message', 'Non-urgent requests'],
                ['Live chat', 'Quick questions'],
                ['Branch', 'In person'],
            ], [
                ['Phone', 'Best for urgent issues and time-sensitive questions.'],
                ['Secure message', 'Send a non-urgent request from online banking and get a written reply.'],
                ['Live chat', 'Fast help with routine questions during business hours.'],
                ['In person', 'Visit a branch for hands-on support.'],
            ], [
                ['Which channel is fastest for a lost card?', 'Lock the card in the app first, then call us so we can review recent activity.'],
            ], ['help-center', 'find-a-branch', 'report-fraud', 'security-center'], ['Contact Us', 'Contact us']),

            'find-a-branch' => C::page('Support', 'Locations', 'Find a Branch', 'Locate branches near you, with hours, services, and accessibility details.', [
                ['Search', 'By ZIP or city'],
                ['Hours', 'Including weekends'],
                ['Services', 'What each offers'],
                ['Accessible', 'Accessibility info'],
            ], [
                ['Hours and services', 'Each location lists its hours and the services it provides.'],
                ['Accessibility', 'Locations list accessibility features and accommodations.'],
                ['Appointments', 'Some branches accept appointments for services that require time.'],
                ['Directions', 'Get directions to your selected location.'],
            ], [
                ['Do I need an appointment?', 'Most everyday transactions are walk-in. Some services benefit from an appointment.'],
            ], ['find-atm', 'contact-us', 'accessibility', 'help-center'], ['Find a Branch', 'Find a branch', 'Find a Branch', 'Branch Locator']),

            'find-atm' => C::page('Support', 'Locations', 'Find an ATM', 'Locate ATMs near you, with fee and access details.', [
                ['Search', 'By ZIP or city'],
                ['Deposit-taking', 'Which ATMs accept deposits'],
                ['Fee info', 'Network and out-of-network'],
                ['24/7', 'Access options'],
            ], [
                ['Deposit capability', 'Filter for ATMs that accept cash deposits.'],
                ['Fee transparency', 'Fee-free at our network; out-of-network fees are disclosed by the owner.'],
                ['Accessibility', 'Accessible ATMs are identified in search results.'],
                ['Always available', 'Network ATMs provide round-the-clock access.'],
            ], [
                ['Are out-of-network ATM fees charged by you?', 'Out-of-network fees are set by the ATM owner, not by us, and are disclosed before you complete a transaction.'],
            ], ['find-a-branch', 'contact-us', 'card-controls', 'help-center'], ['Find an ATM', 'Find an ATM', 'Find an atm', 'ATM Locator']),

            'security-center' => C::hub('Support', 'Security', 'Security Center', 'Simple habits and tools that keep your money and information safe.', [
                ['Protect your accounts', 'Strong passwords and alerts.'],
                ['Recognize fraud', 'Spot common scams.'],
                ['Report a problem', 'Act quickly if something is wrong.'],
                ['Secure technology', 'Device and browser safety.'],
            ], [
                ['What should I do first if I see a fraud charge?', 'Lock your card in the app and contact us right away. Reporting fast limits your exposure.'],
            ]),

            'report-fraud' => C::page('Support', 'Security', 'Report Fraud', 'Act fast. Lock your card, contact us, and we will work with you on what happens next.', [
                ['Immediate', 'Lock your card'],
                ['Fast reporting', 'Limits exposure'],
                ['Investigation', 'We review activity'],
                ['Protection', 'Fraud investigation'],
            ], [
                ['Step 1: Lock your card', 'Use card controls in the app to freeze the card immediately.'],
                ['Step 2: Contact us', 'Call us or send a secure message so we can review recent activity.'],
                ['Step 3: We investigate', 'We review the transactions and take the appropriate action.'],
                ['Step 4: Replace and monitor', 'Request a replacement card and set tighter alerts while it is being issued.'],
            ], [
                ['Am I responsible for fraudulent charges?', 'Liability depends on your cardholder agreement and how quickly you report. Report unauthorized transactions promptly and contact us right away.'],
                ['What if the fraud is on my credit card?', 'Contact the number on the back of the card and also lock it in the app.'],
            ], ['security-center', 'card-controls', 'contact-us', 'alerts'], ['Report Fraud', 'Report fraud', 'Fraud']),

            'account-security' => C::hub('Support', 'Security', 'Security', 'How we protect your accounts and how you can protect yourself.', [
                ['Account security', 'Alerts, multifactor sign-in, and card controls.'],
                ['Your habits', 'Simple practices that prevent most fraud.'],
                ['Scam awareness', 'Recognize common scams.'],
            ], [
                ['What is the single best thing I can do?', 'Turn on transaction alerts. You will see a charge the moment it posts, which is the fastest way to catch fraud.'],
            ]),

            'accessibility' => C::page('Support', 'Accessibility', 'Accessibility', 'Our commitment to making digital banking usable for everyone, and how to get help.', [
                ['Standards', 'WCAG-aligned design'],
                ['Keyboard', 'Full keyboard support'],
                ['Screen readers', 'Tested for assistive tech'],
                ['Assistance', 'Support channels'],
            ], [
                ['Keyboard navigation', 'All interactive elements are reachable and operable by keyboard, with visible focus indicators.'],
                ['Screen reader support', 'Pages are structured with proper headings, labels, and landmarks for assistive technology.'],
                ['Reduced motion', 'Animations respect your system preference for reduced motion.'],
                ['Contact assistance', 'If any part of our site is difficult to use, contact us and we will help another way.'],
            ], [
                ['How do I request an accommodation?', 'Contact us by phone or secure message and we will arrange an accessible alternative.'],
            ], ['contact-us', 'help-center', 'security-center', 'find-a-branch'], ['Accessibility', 'Accessibility']),

            'forgot-password' => C::page('Support', 'Account Access', 'Reset Your Password', 'Regain access to online banking by resetting your password securely.', [
                ['Secure', 'Identity verified'],
                ['Self-service', 'Reset online'],
                ['Temporary', 'Code-based verification'],
                ['Support', 'Help if locked out'],
            ], [
                ['Verify your identity', 'A reset requires confirming information only you would know.'],
                ['Choose a strong password', 'Use a unique password you do not use anywhere else.'],
                ['Sign in on trusted devices only', 'Avoid resetting on shared or public devices.'],
                ['Locked out?', 'Contact us and a specialist will help you regain access.'],
            ], [
                ['How do I reset my password?', 'Select "Forgot password" on the sign-in screen and follow the verification steps.'],
                ['Why did I get a reset email I did not request?', 'If you did not request it, do not use the link. Contact us so we can investigate.'],
            ], ['enroll-online-banking', 'security-center', 'contact-us', 'online-banking'], ['Forgot password', 'Forgot password', 'Reset Password', 'Forgot Password']),

            'enroll-online-banking' => C::page('Support', 'Account Access', 'Enroll in Online Banking', 'Activate online banking and mobile access for your accounts.', [
                ['Steps', 'Guided setup'],
                ['Secure', 'Verified enrollment'],
                ['Alerts', 'Turn on notifications'],
                ['Support', 'Help available'],
            ], [
                ['Have your details ready', 'You need your account number and identification to begin.'],
                ['Create your credentials', 'Choose a username and a strong, unique password.'],
                ['Set up alerts', 'Enable transaction and sign-in alerts to protect your account.'],
                ['Download the app', 'Enroll your phone for mobile banking.'],
            ], [
                ['What do I need to enroll?', 'Your account or routing number and a valid photo ID.'],
                ['Why did I get an enrollment code I did not request?', 'If you did not request it, contact us and do not share the code with anyone.'],
            ], ['forgot-password', 'online-banking', 'mobile-app', 'alerts'], ['Enroll in online banking', 'Enroll in online banking', 'Enroll in Online Banking']),

        ];
    }
}
