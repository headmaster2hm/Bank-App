<?php

namespace App\Support\Content;

use App\Support\MarketingCatalog as C;

class LegalContent
{
    /** @return array<string, array<string, mixed>> */
    public static function pages(): array
    {
        $notice = 'This page is part of a demonstration prototype and is not a legal document. A real institution would publish its current, approved policies here.';

        return [

            'privacy' => C::page('Legal', 'Legal', 'Privacy Policy', 'How we collect, use, and protect personal information.', [
                ['Transparent', 'What we collect'],
                ['Your choices', 'Your rights'],
                ['Secure', 'How we protect data'],
                ['Contact', 'Questions'],
            ], [
                ['Information we collect', 'Account information, transaction history, and information you provide when you apply for a product.'],
                ['How we use it', 'To service your accounts, meet legal obligations, prevent fraud, and improve our services.'],
                ['Sharing', 'We share information only with service providers and as required by law.'],
                ['Your rights', 'You can request access, correction, or deletion of your information, subject to legal requirements.'],
            ], [
                ['How do I request my information?', 'Contact us through the Contact page. We verify your identity before fulfilling a request.'],
            ], ['terms', 'data-security', 'disclosures', 'accessibility'], ['Privacy Policy', 'Privacy', 'Privacy policy', 'Privacy Policy'], 'legal', 'Contact Us', 'contact-us'),

            'terms' => C::page('Legal', 'Legal', 'Terms & Conditions', 'The terms that govern your use of our website and services.', [
                ['Agreement', 'Terms of use'],
                ['Accounts', 'Your responsibilities'],
                ['Accuracy', 'Information on this site'],
                ['Contact', 'Questions'],
            ], [
                ['Website use', 'Terms governing your use of this site and its content.'],
                ['Account terms', 'Your specific account terms are set out in the agreement you signed.'],
                ['Accuracy', 'We work to keep information accurate, but errors can occur. Verify details before acting.'],
                ['Changes', 'Terms may be updated. Continued use constitutes acceptance.'],
            ], [], ['privacy', 'disclosures', 'data-security', 'cookie-policy'], ['Terms & Conditions', 'Terms', 'Terms of Use', 'Terms & Conditions'], 'legal', 'Contact Us', 'contact-us'),

            'disclosures' => C::page('Legal', 'Legal', 'Disclosures', 'Regulatory, product, and rate disclosures in one place.', [
                ['Regulatory', 'Filings and status'],
                ['Products', 'Terms and pricing'],
                ['Rates', 'APY and APR'],
                ['Insurance', 'Coverage information'],
            ], [
                ['Regulatory disclosures', 'A real institution would publish its regulatory status, charters, and filings here.'],
                ['Product disclosures', 'Full terms, pricing, and pricing schedules for each product.'],
                ['Rate disclosures', 'APY, APR, and the assumptions behind advertised rates.'],
                ['Insurance information', 'Details of any deposit insurance or coverage arrangements.'],
            ], [
                ['Where do I find a product disclosure?', 'Each product page links to its full terms. Those agreements, not this summary, control your account.'],
            ], ['licensing', 'institution-details', 'rates', 'privacy'], ['Disclosures', 'Disclosures', 'Disclosures'], 'legal', 'Contact Us', 'contact-us'),

            'licensing' => C::page('Legal', 'Legal', 'Licensing & Regulatory Filings', 'Regulatory status, charters, and public filings.', [
                ['Charter', 'Institutional status'],
                ['Filings', 'Public reports'],
                ['Regulators', 'Supervisory bodies'],
                ['Contact', 'Questions'],
            ], [
                ['Institutional charter', 'A real institution publishes its charter and organizing documents here.'],
                ['Public filings', 'Periodic reports filed with regulators are linked from this page.'],
                ['Supervisory information', 'Primary regulators and their filings are listed here.'],
                ['Consumer protection', 'Regulatory resources for consumers are linked below.'],
            ], [
                ['Are you a real, regulated institution?', 'No. This is a demonstration prototype. No real institution details, license numbers, or regulatory affiliations are represented.'],
            ], ['institution-details', 'disclosures', 'investor-relations', 'about'], ['Licensing & Regulatory Filings', 'Licensing and regulatory filings', 'Licensing'], 'legal', 'Contact Us', 'contact-us'),

            'institution-details' => C::page('Legal', 'Legal', 'Official Institution Details', 'Legal entity, addresses, and contact details for the institution.', [
                ['Entity', 'Legal name'],
                ['Addresses', 'Offices and mailing'],
                ['Contact', 'How to reach us'],
                ['Hours', 'Service availability'],
            ], [
                ['Legal entity', 'A real institution publishes its exact legal name and charter details here.'],
                ['Addresses', 'Principal office and customer service addresses.'],
                ['Contact details', 'Verified phone numbers and mailing address.'],
                ['Accessibility', 'Accommodations and alternative formats are available on request.'],
            ], [
                ['Where is the institution located?', 'This prototype does not represent a real institution and intentionally omits invented addresses, phone numbers, and charter details.'],
            ], ['licensing', 'disclosures', 'accessibility', 'contact-us'], ['Official Institution Details', 'Official institution details', 'Institution Details'], 'legal', 'Contact Us', 'contact-us'),

            'cookie-policy' => C::page('Legal', 'Legal', 'Cookie Policy', 'How cookies and similar technologies are used on this site.', [
                ['Essential', 'Required for function'],
                ['Analytics', 'Improve the site'],
                ['Choices', 'Manage preferences'],
                ['Questions', 'Contact us'],
            ], [
                ['Essential cookies', 'Required for core site functions like signing in and security.'],
                ['Analytics', 'Help us understand how the site is used so we can improve it.'],
                ['Your choices', 'You can manage or refuse non-essential cookies in your browser settings.'],
                ['Do Not Track', 'We honor browser Do Not Track signals where applicable.'],
            ], [
                ['How do I change my cookie settings?', 'You can configure or block cookies in your browser settings. Essential cookies are required for the site to work.'],
            ], ['privacy', 'terms', 'data-security', 'accessibility'], ['Cookie Policy', 'Cookie policy', 'Cookies', 'Cookie Policy'], 'legal', 'Contact Us', 'contact-us'),

            'data-security' => C::hub('Legal', 'Legal', 'Security', 'How we protect your information, and how you can help.', [
                ['Data protection', 'Encryption in transit.'],
                ['Access control', 'Multi-factor authentication.'],
                ['Monitoring', 'Fraud detection.'],
                ['Your habits', 'Simple steps that help.'],
            ], [
                ['What should I do if something looks wrong?', 'Lock your card in the app and contact us immediately.'],
            ]),

        ];
    }
}
