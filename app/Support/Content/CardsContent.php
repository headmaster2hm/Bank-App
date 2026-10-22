<?php

namespace App\Support\Content;

use App\Support\MarketingCatalog as C;

class CardsContent
{
    /** @return array<string, array<string, mixed>> */
    public static function pages(): array
    {
        return [

            'credit-cards' => C::hub('Cards', 'Credit Cards', 'Credit Cards', 'Rewards, protections, and clear pricing across our card lineup.', [
                ['Cash Back Card', 'Straightforward rewards on everyday spending.'],
                ['Travel Rewards Card', 'Points toward travel, with redemption flexibility.'],
                ['Everyday Rewards Card', 'Broad earning across common categories.'],
                ['Premium Card', 'Higher rewards plus added protections.'],
                ['Secured Card', 'Build credit with a deposit-backed limit.'],
            ], [
                ['How do I qualify?', 'Approval depends on a credit review. Pre-qualification lets you check for options with no impact to your score.'],
            ]),

            'all-credit-cards' => C::hub('Cards', 'Compare', 'Compare Credit Cards', 'Rewards rates, annual fees, and protections laid out side by side.', [
                ['Compare cards', 'Every credit card we offer.'],
                ['Pre-qualify', 'Check options with no score impact.'],
                ['Rewards', 'Earning on common categories.'],
            ], [
                ['Does pre-qualification affect my credit?', 'Pre-qualification uses a soft review and does not affect your credit score.'],
            ], 'hub', ['All Credit Cards', 'All credit cards', 'Apply Now', 'Apply now', 'Compare Credit Cards']),

            'cash-back-card' => C::page('Cards', 'Credit Cards', 'Cash Back Card', 'Earn a straightforward return on everyday purchases, with no points system to learn.', [
                ['Cash back', 'On all purchases'],
                ['$0', 'Annual fee'],
                ['No points', 'No redemption schedule'],
                ['0% intro', 'On qualifying transfers'],
            ], [
                ['Earn on everything', 'A flat rate applies across all purchases, with no rotating categories to track.'],
                ['Redeem as statement credit', 'Cash back appears directly on your statement rather than as points to manage.'],
                ['No annual fee', 'There is no annual fee on this card.'],
                ['Purchase protection', 'Coverage against damage or loss on eligible purchases, subject to terms.'],
            ], [
                ['Does the cash back expire?', 'Cash back credited to your account does not expire while the account is open.'],
                ['Is there a foreign transaction fee?', 'Foreign transaction fees do not apply to this card.'],
            ], ['everyday-rewards-card', 'travel-rewards-card', 'premium-card', 'card-benefits'], ['Cash Back Card', 'Cash back card']),

            'everyday-rewards-card' => C::page('Cards', 'Credit Cards', 'Everyday Rewards Card', 'Broader category rewards for households whose spending spans groceries, dining, and travel.', [
                ['Categories', 'Multiple earning rates'],
                ['$0', 'Annual fee'],
                ['Flexible', 'Point redemption'],
                ['Purchase protection', 'On eligible items'],
            ], [
                ['Category rewards', 'Higher earning on frequently used categories, with a base rate on everything else.'],
                ['Points you choose', 'Redeem against statement credit, travel, or merchandise.'],
                ['No annual fee', 'There is no annual fee on this card.'],
                ['Travel notice', 'Add a notice before a trip to avoid friction on your card.'],
            ], [
                ['How do redemption values work?', 'Point values vary by redemption type and are listed in your cardholder agreement.'],
            ], ['cash-back-card', 'travel-rewards-card', 'card-benefits', 'all-credit-cards'], ['Everyday Rewards Card', 'Everyday rewards card']),

            'travel-rewards-card' => C::page('Cards', 'Credit Cards', 'Travel Rewards Card', 'Earn points on travel spend and redeem them toward flights, hotels, and everyday travel costs.', [
                ['3x', 'On travel purchases'],
                ['Points', 'Flexible redemption'],
                ['Travel', 'Protections included'],
                ['$0', 'Foreign transaction fee'],
            ], [
                ['Travel-focused earning', 'Higher earning on airfare, lodging, and travel-related purchases.'],
                ['Transfer partners', 'Redeem points through participating travel programs.'],
                ['Trip protections', 'Coverage for eligible trip interruption and lost baggage, subject to terms.'],
                ['No foreign transaction fee', 'Use the card abroad without a conversion surcharge.'],
            ], [
                ['Do points expire?', 'Points do not expire while your account is open and in good standing.'],
                ['Are there travel fees for redeeming points?', 'Redemption fees vary by travel partner and are shown before you confirm a booking.'],
            ], ['everyday-rewards-card', 'premium-card', 'card-benefits', 'all-credit-cards'], ['Travel Rewards Card', 'Travel rewards card']),

            'premium-card' => C::page('Cards', 'Credit Cards', 'Premium Card', 'Our highest-tier card, pairing elevated rewards with added protections and concierge service.', [
                ['Premium', 'Elevated rewards'],
                ['Concierge', 'Travel assistance'],
                ['Annual fee', 'Stated and disclosed'],
                ['Protection', 'Expanded coverage'],
            ], [
                ['Elevated earning', 'Higher rewards on travel and dining, with strong base rates elsewhere.'],
                ['Concierge service', 'Assist with reservations, travel changes, and gift arrangements.'],
                ['Expanded protections', 'Broader coverage and higher limits on eligible purchase protection.'],
                ['Airport and travel benefits', 'Access to benefits depends on cardholder status and is described in your agreement.'],
            ], [
                ['Is there an annual fee?', 'Yes. The annual fee is disclosed on the application before you accept the card.'],
            ], ['travel-rewards-card', 'cash-back-card', 'card-benefits', 'all-credit-cards'], ['Premium Card', 'Premium card']),

            'secured-card' => C::page('Cards', 'Credit Cards', 'Secured Card', 'A credit card backed by a deposit you already have, designed to help you build credit history responsibly.', [
                ['Deposit', 'Sets your credit limit'],
                ['$0', 'Annual fee'],
                ['Reports', 'Sent to credit bureaus'],
                ['Builds', 'Credit history over time'],
            ], [
                ['How the limit works', 'Your refundable deposit determines the credit limit. A higher deposit generally means a higher limit.'],
                ['Deposit return', 'The deposit stays with us as collateral. It does not reduce the balance you owe.'],
                ['Gradual increases', 'We review eligible accounts over time and may raise the limit as your history builds.'],
                ['Same card features', 'Purchase protection and fraud monitoring apply, subject to terms.'],
            ], [
                ['What happens if I close the account?', 'Any deposit remaining after the balance is paid is returned to you.'],
                ['Is the deposit refundable?', 'It is refundable. It is held as collateral, so it is not available for purchases.'],
            ], ['cash-back-card', 'all-credit-cards', 'card-benefits'], ['Secured Card', 'Secured card', 'Secured Credit Card', 'Secured Starter']),

            'card-benefits' => C::hub('Cards', 'Compare', 'Credit Card Benefits', 'Protections, rewards, and services that come with each card.', [
                ['Purchase protection', 'Damage and loss coverage on eligible purchases.'],
                ['Fraud monitoring', 'Alerts on suspicious card activity.'],
                ['Prompt reporting', 'Protocols for flagging unauthorized transactions quickly.'],
                ['Travel notices', 'Flag trips so your card keeps working.'],
            ], [
                ['What should I do if I see a charge I do not recognize?', 'Lock the card in the app and contact us right away. Reporting quickly limits your exposure.'],
            ], 'hub', ['Card Benefits', 'Card benefits', 'Credit Card Benefits']),

            'debit-cards' => C::hub('Cards', 'Debit Cards', 'Debit Cards', 'Cards linked to your deposit balance for everyday purchases and ATM use.', [
                ['Standard Debit', 'Everyday purchasing and ATM access.'],
                ['Premium Debit', 'Enhanced benefits and higher limits.'],
                ['Student Debit', 'No annual fee for students.'],
                ['Card Controls', 'Lock, limit, and track your card.'],
            ], [
                ['Do debit cards affect my credit?', 'Debit card activity is reported to account management, not to credit bureaus.'],
            ]),

            'all-debit-cards' => C::hub('Cards', 'Compare', 'Compare Debit Cards', 'Fees, ATM terms, and benefits across our debit cards.', [
                ['Standard Debit', 'No annual fee.'],
                ['Premium Debit', 'Enhanced benefits.'],
                ['Student Debit', 'No annual fee while enrolled.'],
            ], [
                ['Can I get more than one card?', 'Cardholder limits are set per account and are disclosed when you open the account.'],
            ], 'hub', ['All Debit Cards', 'All debit cards', 'Compare Debit Cards']),

            'standard-debit' => C::page('Cards', 'Debit', 'Standard Debit Card', 'A no-annual-fee debit card for purchases, ATM withdrawals, and bill payments.', [
                ['$0', 'Annual fee'],
                ['Contactless', 'Tap to pay'],
                ['ATM', 'Fee-free at our network'],
                ['24/7', 'Lock and replace'],
            ], [
                ['No annual fee', 'There is no annual charge for this card.'],
                ['Contactless and chip', 'Tap, insert, or swipe at participating terminals.'],
                ['ATM access', 'Fee-free withdrawals at network ATMs, with fees disclosed at out-of-network locations.'],
                ['Instant lock', 'Freeze the card instantly in the app and unfreeze it when you need it.'],
            ], [
                ['Are there ATM fees?', 'In-network ATMs are free. Out-of-network fees are disclosed by the ATM owner before you complete a withdrawal.'],
            ], ['premium-debit', 'student-debit', 'card-controls', 'mobile-app'], ['Standard Debit', 'Standard debit']),

            'premium-debit' => C::page('Cards', 'Debit', 'Premium Debit Card', 'A debit card with higher limits, extended ATM access, and travel benefits.', [
                ['Higher limits', 'Daily purchase and ATM caps'],
                ['Travel', 'Foreign transaction benefits'],
                ['Concierge', 'Assistance while away'],
                ['Annual fee', 'Stated and disclosed'],
            ], [
                ['Higher daily limits', 'Increased daily purchase and ATM withdrawal caps.'],
                ['Travel benefits', 'Foreign transaction terms and travel notice support.'],
                ['Concierge assistance', 'Help arranging travel and resolving issues away from home.'],
                ['Linked to your account', 'Works with any eligible deposit account.'],
            ], [
                ['Is there an annual fee?', 'Yes. The annual fee is disclosed on the application before you accept.'],
            ], ['standard-debit', 'student-debit', 'card-controls', 'credit-cards'], ['Premium Debit', 'Premium debit']),

            'student-debit' => C::page('Cards', 'Debit', 'Student Debit Card', 'A no-fee debit card designed for students, with a lower overdraft cushion.', [
                ['$0', 'Annual fee'],
                ['Cushion', 'No overdraft penalty below limit'],
                ['No fee', 'While enrolled'],
                ['24/7', 'App controls'],
            ], [
                ['No annual fee', 'No annual charge while you remain enrolled at an eligible institution.'],
                ['Overdraft cushion', 'No penalty if you stay within a modest buffer, which helps students avoid fees.'],
                ['Real-time alerts', 'Know immediately when a purchase posts.'],
                ['Convert after graduation', 'Your card converts with 30 days notice when student status ends.'],
            ], [
                ['What is the overdraft cushion?', 'A small amount you can overdraw without a penalty. The exact figure appears in your account agreement.'],
            ], ['standard-debit', 'student-checking', 'card-controls', 'mobile-app'], ['Student Debit', 'Student debit']),

            'card-controls' => C::page('Cards', 'Debit', 'Card Controls', 'Lock, limit, and monitor your cards from the mobile app without calling us.', [
                ['Instant', 'Lock and unlock'],
                ['Limits', 'Per-channel caps'],
                ['Alerts', 'Every swipe'],
                ['Report', 'Lost or stolen'],
            ], [
                ['Lock and unlock', 'Freeze a card instantly and unfreeze it when you pick it up again.'],
                ['Channel controls', 'Set separate limits for card-present and online purchases.'],
                ['Merchant controls', 'Allow or block specific merchants from your card.'],
                ['Report lost or stolen', 'Report a missing card and request a replacement in the same flow.'],
            ], [
                ['Does locking a card stop recurring charges?', 'Recurring charges on a locked card are typically declined. Remove the merchant to stop them.'],
            ], ['standard-debit', 'mobile-app', 'report-fraud', 'security-center'], ['Card Controls', 'Card controls']),

        ];
    }
}
