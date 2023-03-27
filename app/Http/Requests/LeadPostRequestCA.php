<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LeadPostRequestCA extends FormRequest
{
    /**
     * Indicates if the validator should stop on the first rule failure.
     *
     * @var bool
     */
    protected $stopOnFirstFailure = true;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'vid' => 'required',
            'tier' => 'required',

            'loanAmount' => 'required|gte:50|lte:5000|multiple_of:50|numeric',
//
            'loanTerms' => [
                'required',
                Rule::in('3','6','12','18','24','36'),
            ],

            'nameTitle' => [
                'required',
                Rule::in('Mr', 'Miss', 'Mrs', 'Ms'),
            ],

            'firstName' => [
                'required', 'min:2', 'regex:/^[a-zA-Z-\'" ]+$/',
                Rule::notIn('Mr', 'Miss', 'Mrs', 'Ms'),
            ],
//
//            'lastName' => [
//                'required', 'different:firstName','min:2', 'regex:/^[a-zA-Z-\'" ]+$/',
//                Rule::notIn('Mr', 'Miss', 'Mrs', 'Ms'),
//            ],
//
//            // add : + 18 years old
//            'dateOfBirth' => 'required', 'date_format:d/m/Y',
//
            'homePhoneNumber' => 'required',
            'cellPhoneNumber' => 'required',
            'workPhoneNumber' => 'required',
//
////            'employerName' => 'sometimes|required|min:2',
////            'jobTitle' => 'sometimes|required|min:2',
////
            'email' => 'required', 'email:rfc, dns, spoof, filter',
//
            'maritalStatus' => [
                'required',
                Rule::in(
                    'Single',
                    'Married',
                    'LivingTogether',
                    'Separated',
                    'Divorced',
                    'Widowed',
                    'Other'),
            ],
////
            'dependants' => [
                'required',
                Rule::in('0', '1', '2', '3'),
            ],
//            'residentialStatus' => [
//                'required',
//                Rule::in(
//                    'HomeOwner',
//                    'PrivateTenant',
//                    'CouncilTenant',
//                    'LivingWithParents',
//                    'LivingWithFriends',
//                    'Other'),
//            ],
//            'monthsAtAddress' => [
//                'required',
//                Rule::in('12','24','36','48','60','96'),
//            ],
//
////            'houseNumber' => 'required',
////            'houseName' => 'required',
////            'flatNumber' => 'required',
//            'addressStreet1' => 'required', 'different:houseNumber',
//            'city' => 'required', 'min2',
//            'locality' => 'required', 'min:2',
//            'county' => 'required', 'min:2',
//            'monthlyMortgageRent' => 'required', 'numeric',
//            'postCode' => [
//                'required', 'min:7',
//            ],
//            'incomeSource' =>  [
//                'required',
//                Rule::in('SelfEmployed',
//                    'EmployedFullTime',
//                    'EmployedPartTime',
//                    'EmployedTemporary',
//                    'Pension',
//                    'DisabilityBenefits',
//                    'Benefits'),
//            ],
//            'incomeCycle' => [
//                'required',
//                Rule::in('SpecificDayOfMonth',
//                    'Weekly',
//                    'BiWeekly',
//                    'Fortnightly',
//                    'LastDayMonth',
//                    'LastWorkingDayMonth',
//                    'TwiceMonthly',
//                    'FourWeekly',
//                    'LastFriday',
//                    'LastThursday',
//                    'LastWednesday',
//                    'LastTuesday',
//                    'LastMonday'),
//            ],
//            'monthlyIncome' => 'required', 'gte:500', 'lte:15000', 'numeric',
//            'nextPayDate1' => 'required', 'date', 'date_format:d/m/Y',
//            'nextPayDate2' => 'required', 'date', 'date_format:d/m/Y',
//
//            'monthlyRepayments' => 'required', 'numeric',
//            'monthlyUtilities' => 'required', 'numeric',
//            'monthlyTransport' => 'required', 'numeric',
//            'monthlyFood' => 'required', 'numeric',
//            'otherExpense' => 'required', 'numeric',
//
//            'bankCardType' => [
//                'required',
//                Rule::in('Solo',
//                    'SwitchMaestro',
//                    'Visa',
//                    'VisaDebit',
//                    'VisaDelta',
//                    'VisaElectron',
//                    'VisaElectron',
//                    'MasterCard',
//                    'MasterCardDebit'),
//            ],
//            'bankAccountNumber' => 'required', 'size:8',
//            'bankRoutingNumber' => 'required', 'size:6',
//            'consentFinancial' => 'accepted',
//            'ipAddress' => 'required',
//            'userAgent' => 'required',
//            'creationUrl' => 'required',
//            'referringUrl' => 'required',
//            'combined_pay' => 'sometimes', 'required', '' [21]
//             employmentMonth
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'vid.required' => 'A vid is required',
//            'tier.required' => 'A tier is required',
//            'loanPurpose.required' => 'Please choose one of the following:
//                        Subsistence,
//                        OneOffPurchase,
//                        Other,
//                        DebtConsolidation,
//                        CarLoan,
//                        PayBills,
//                        PayOffLoan,
//                        ShortTermCash,
//                        HomeImprovements',
//
//            'loanAmount.required' => 'Loan amount must be in multiples of 100,  ex: 1100, 1200, etc.',
//
//            'loanTerms.required' => 'The selected loan term is not applicable on the loan amount entered',
//
//            'nameTitle.required' => '',
//            'firstName.required' => 'First name can contain only alphabets and spaces',
//
//            'lastName.required' => 'Last name can contain only alphabets, spaces, hyphens and apostrophes',
//
//            // add : + 18 years old
//            'dateOfBirth.required' => 'You must be 18 years or older to apply',
//
//            // check email
//            'email.required' => 'Please enter a valid email',
//            'maritalStatus.required' => 'Please enter a valid maritalStatus',
//            'dependants.required' => 'Please enter a valid dependants',
//            'homePhoneNumber.required' => 'Please enter a valid homePhoneNumber number',
//            'mobilePhoneNumber.required' => 'Please enter a valid mobilePhoneNumber number',
//            'workPhoneNumber.required' => 'Please enter a valid workPhoneNumber number',
//            'employerName.required' => 'Please enter a valid employerName',
//            'monthsAtAddress.required' => 'Please choose one of the following options: 12, 24, 36, 48, 60, 96',
////            // timeinwork
////            'employmentYear' => [
////                'required', 'min:6', 'max:8',
////                Rule::in('12','24','36','48','60','96'),
////            ],
//            'employerIndustry.required' => 'Please enter a valid employerIndustry',
//            'incomeSource.required' => 'Please enter a valid incomeSource',
//            'incomeCycle.required' => 'Please enter a valid incomeCycle',
//            'monthlyIncome.required' => 'Please enter a valid monthlyIncome',
//            'nextPayDate1' => 'Please enter a valid nextPayDate1',
//            'nextPayDate2' => 'Please enter a valid nextPayDate2',
//            'houseNumber.required' => 'Please enter a valid houseNumber',
////            'houseName' => 'required',
////            'flatNumber' => 'required',////
//            'addressStreet1.required' => 'Please enter a valid addressStreet1',
//            'city.required' => 'Please enter a valid city',
//            'locality.required' => 'Please enter a valid locality',
//            'county.required' => 'Please enter a valid county',
//            'postCode.required' => 'Please enter a valid postcode',
//            'residentialStatus.required' => 'Residential Status error',
//            'monthlyMortgageRent.required' => 'Please enter a valid monthlyMortgageRent',
//            'monthlyRepayments.required' => 'Please enter a valid monthlyRepayments',
//            'monthlyUtilities.required' => 'Please enter a valid monthlyUtilities',
//            'monthlyTransport.required' => 'Please enter a valid monthlyTransport',
//            'monthlyFood.required' => 'Please enter a valid monthlyFood',
//            'otherExpense.required' => 'Please enter a valid otherExpense',
//            'bankCardType.required' => 'Please enter a valid bankCardType',
//            'bankAccountNumber.required' => 'Please enter a valid bankAccountNumber',
//            'bankRoutingNumber.required' => 'Please enter a valid bankRoutingNumber',
////            // check: accepted
//            'consentFinancial.required' => 'Please enter a valid consentFinancial',
//            'consentCreditSearch.required' => 'Please enter a valid consentCreditSearch',
//            'consentThirdPartyEmails.required' => 'Please enter a valid consentThirdPartyEmails',
//            'consentThirdPartySMS.required' => 'Please enter a valid consentThirdPartySMS',
//            'consentThirdPartyPhone.required' => 'Please enter a valid consentThirdPartyPhone',
//            'ipAddress.required' => 'Please enter a valid ipAddress',
//            'userAgent.required' => 'Please enter a valid userAgent',
//            'creationUrl.required' => 'Please enter a valid creationUrl',
//            'referringUrl.required' => 'Please enter a valid referringUrl',
//
//            'combined_pay' => 'Combined pay is invalid.',


        ];

    }
}
