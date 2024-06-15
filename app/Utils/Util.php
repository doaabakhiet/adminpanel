<?php

namespace App\Utils;

use App\Models\Currency;
use App\Models\Employee;

use App\Models\System;
use App\Models\User;
use App\Models\WageTransaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Util
{
    /**
     * This function unformats a number and returns them in plain eng format
     *
     * @param int $input_number
     *
     * @return float
     */
    public function num_uf($input_number, $currency_details = null)
    {
        $thousand_separator  = ',';
        $decimal_separator  = '.';

        $num = str_replace($thousand_separator, '', $input_number);
        $num = str_replace($decimal_separator, '.', $num);

        return (float)$num;
    }

    /**
     * This function formats a number and returns them in specified format
     *
     * @param int $input_number
     * @param boolean $add_symbol = false
     * @param object $business_details = null
     * @param boolean $is_quantity = false; If number represents quantity
     *
     * @return string
     */
    public function num_f($input_number, $add_symbol = false, $business_details = null, $is_quantity = false)
    {
        $thousand_separator = ',';
        $decimal_separator = '.';

        $currency_precision =  !empty(System::getProperty('numbers_length_after_dot')) ? System::getProperty('numbers_length_after_dot') : 2;

        if ($is_quantity) {
            $currency_precision = !empty(System::getProperty('numbers_length_after_dot')) ? System::getProperty('numbers_length_after_dot') : 2;
        }

        $formatted = number_format($input_number, $currency_precision, $decimal_separator, $thousand_separator);

        if ($add_symbol) {
            $currency_symbol_placement = !empty($business_details) ? $business_details->currency_symbol_placement : session('business.currency_symbol_placement');
            $symbol = !empty($business_details->currency_symbol) ? $business_details->currency_symbol : session('currency')['symbol'];

            if ($currency_symbol_placement == 'after') {
                $formatted = $formatted . ' ' . $symbol;
            } else {
                $formatted = $symbol . ' ' . $formatted;
            }
        }

        return $formatted;
    }

    /**
     * Calculates percentage for a given number
     *
     * @param int $number
     * @param int $percent
     * @param int $addition default = 0
     *
     * @return float
     */
    public function calc_percentage($number, $percent, $addition = 0)
    {
        return ($addition + ($number * ($percent / 100)));
    }

    /**
     * Calculates base value on which percentage is calculated
     *
     * @param int $number
     * @param int $percent
     *
     * @return float
     */
    public function calc_percentage_base($number, $percent)
    {
        return ($number * 100) / (100 + $percent);
    }

    public function calculateEmployeeCommission($employee_id, $start_date = null, $end_date = null)
    {
        $employee = Employee::find($employee_id);
        $query = WageTransaction::latest();
        if (!empty($start_date)) {
            $query->whereDate('transaction_date', '>=', $this->uf_date($start_date));
        }
        if (!empty($end_date)) {
            $query->whereDate('transaction_date', '<=', $this->uf_date($end_date));
        }
        // $query->where('payment_status', '!=', 'paid')
        //     ->where('type', 'employee_commission')
        //     ->where('employee_id', $employee_id);
        $sale_transactions = $query->select(
            'wage_transactions.final_total',
            'wage_transactions.id'
        )
            ->get();

        $amount = 0;
        $default_currency_id = System::getProperty('currency');
        if ($employee->commission == 1) {
            if (!empty($sale_transactions) && $sale_transactions->count() > 0) {
                foreach ($sale_transactions as $transaction) {
                    $final_total = $transaction->final_total - $this->getTotalPaid($transaction->id);
                    if (!empty($transaction->paying_currency_id)) {
                        if ($transaction->paying_currency_id != $default_currency_id) {
                            // $amount += $this->convertCurrencyAmount($final_total, $transaction->paying_currency_id, $default_currency_id);
                        } else {
                            $amount += $final_total;
                        }
                    } else {
                        $amount += $final_total;
                    }
                }
            }
        }

        return $amount;
    }
    public function getTotalPaid($transaction_id)
    {
        $total_paid = WageTransaction::where('transaction_id', $transaction_id)
            ->select(DB::raw('SUM(IF( is_return = 0, amount, amount*-1))as total_paid'))
            ->first()
            ->total_paid;

        return $total_paid;
    }

    /**
     * Calculates percentage
     *
     * @param int $base
     * @param int $number
     *
     * @return float
     */
    public function get_percent($base, $number)
    {
        if ($base == 0) {
            return 0;
        }

        $diff = $number - $base;
        return ($diff / $base) * 100;
    }

    /**
     * Converts date in business format to mysql format
     *
     * @param string $date
     * @param bool $time (default = false)
     * @return strin
     */
    public function uf_date($date, $time = false)
    {
        $date_format = 'm/d/Y';
        $mysql_format = 'Y-m-d';
        if ($time) {
            if (System::getProperty('time_format') == 12) {
                $date_format = $date_format . ' h:i A';
            } else {
                $date_format = $date_format . ' H:i';
            }
            $mysql_format = 'Y-m-d H:i:s';
        }

        return !empty($date_format) ? Carbon::createFromFormat($date_format, $date)->format($mysql_format) : null;
    }

    /**
     * Converts time in business format to mysql format
     *
     * @param string $time
     * @return strin
     */
    // public function uf_time($time)
    // {
    //     $time_format = 'H:i';
    //     if (System::getProperty('time_format') == 12) {
    //         $time_format = 'h:i A';
    //     }
    //     return !empty($time_format) ? Carbon::createFromFormat($time_format, $time)->format('H:i') : null;
    // }

    /**
     * Converts time in business format to mysql format
     *
     * @param string $time
     * @return strin
     */
    // public function format_time($time)
    // {
    //     $time_format = 'H:i';
    //     if (System::getProperty('time_format') == 12) {
    //         $time_format = 'h:i A';
    //     }
    //     return !empty($time) ? Carbon::createFromFormat('H:i:s', $time)->format($time_format) : null;
    // }

    /**
     * Converts date in mysql format to business format
     *
     * @param string $date
     * @param bool $time (default = false)
     * @return strin
     */
    public function format_date($date, $show_time = false, $business_details = null)
    {
        $format = 'm/d/Y';
        if (!empty($show_time)) {
            $time_format = '';
            if ($time_format == 12) {
                $format .= ' h:i A';
            } else {
                $format .= ' H:i';
            }
        }

        return !empty($date) ? Carbon::createFromTimestamp(strtotime($date))->format($format) : null;
    }

    /**
     * Generates unique token
     *
     * @param void
     *
     * @return string
     */
    public function generateToken()
    {
        return md5(rand(1, 10) . microtime());
    }

    /**
     * Checks whether mail is configured or not
     *
     * @return boolean
     */
    public function IsMailConfigured()
    {
        $is_mail_configured = false;

        if (
            !empty(env('MAIL_DRIVER')) &&
            !empty(env('MAIL_HOST')) &&
            !empty(env('MAIL_PORT')) &&
            !empty(env('MAIL_USERNAME')) &&
            !empty(env('MAIL_PASSWORD')) &&
            !empty(env('MAIL_FROM_ADDRESS'))
        ) {
            $is_mail_configured = true;
        }

        return $is_mail_configured;
    }


    /**
     * Retrieves user role name.
     *
     * @return string
     */
    public function getUserRoleName($user_id)
    {
        $user = User::findOrFail($user_id);

        $roles = $user->getRoleNames();

        $role_name = '';

        if (!empty($roles[0])) {
            $array = explode('#', $roles[0], 2);
            $role_name = !empty($array[0]) ? $array[0] : '';
        }
        return $role_name;
    }

    /**
     * Retrieves IP address of the user
     *
     * @return string
     */
    public function getUserIpAddr()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            //ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            //ip pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    public function createDropdownHtml($array, $append_text = null)
    {
        $html = '';
        if (!empty($append_text)) {
            $html = '<option value="">' . $append_text . '</option>';
        }
        foreach ($array as $key => $value) {
            $html .= '<option value="' . $key . '">' . $value . '</option>';
        }

        return $html;
    }



    public function getPurchaseOrderStatusArray()
    {
        return [
            'draft' => __('lang.draft'),
            'sent_admin' => __('lang.sent_to_admin'),
            'sent_supplier' => __('lang.sent_to_supplier'),
            'received' => __('lang.received'),
            'pending' => __('lang.pending'),
            'partially_received' => __('lang.partially_received'),
        ];
    }
    public function getPaymentStatusArray()
    {
        return [
            'partial' => __('lang.partially_paid'),
            'paid' => __('lang.paid'),
            'pending' => __('lang.pay_later'),
        ];
    }

    public function getPaymentTypeArray()
    {
        return [
            'cash' => __('lang.cash'),
            'card' => __('lang.credit_card'),
            'bank_transfer' => __('lang.bank_transfer'),
            'cheque' => __('lang.cheque'),
            'money_transfer' => 'Money Transfer',
        ];
    }
    public function getPaymentTypeArrayForPos()
    {
        return [
            'cash' => __('lang.cash'),
            'card' => __('lang.credit_card'),
            'cheque' => __('lang.cheque'),
            'gift_card' => __('lang.gift_card'),
            'bank_transfer' => __('lang.bank_transfer'),
            'deposit' => __('lang.use_the_balance'),
            'paypal' => __('lang.paypal'),
        ];
    }

    /**
     * Gives a list of all currencies
     *
     * @return array
     */
    public function allCurrencies($exclude_array = [])
    {
        $query = Currency::select('id', DB::raw("concat(country, ' - ',currency, '(', code, ') ', symbol) as info"))
            ->orderBy('country');
        if (!empty($exclude_array)) {
            $query->whereNotIn('id', $exclude_array);
        }

        $currencies = $query->pluck('info', 'id');

        return $currencies;
    }

    /**
     * Gives a list of all timezone with gmt offset
     *
     * @return array
     */
    public function allTimeZones()
    {
        $timezones = [];
        foreach (timezone_identifiers_list() as $key => $zone) {
            $timezone = timezone_open($zone);

            $datetime_eur = date_create("now", timezone_open("Europe/London"));
            $gmt_offset = timezone_offset_get($timezone, $datetime_eur);
            $offset = $this->convertToHoursMins($gmt_offset);
            if ($gmt_offset > 0) {
                $timezones[$zone] = $zone . ' (GMT +' . $offset . ')';
            } else if ($gmt_offset < 0) {
                $timezones[$zone] = $zone . ' (GMT ' . $offset . ')';
            } else {
                $timezones[$zone] = $zone . ' (GMT +00:00)';
            }
        }
        return $timezones;
    }


    function convertToHoursMins($time)
    {
        $hours = floor($time / 3600);
        $x = $time / 3600;
        $remain_nimutes = $x - floor($x);;
        $minutes = ($remain_nimutes * 60);
        return $hours . ':' . str_pad($minutes, 2, "0");;
    }
    /**
     * find user of sepcific role
     *
     * @return void
     */
    public function getTheUserByRole($role_name)
    {
        $users = User::all();

        foreach ($users as $user) {
            if ($user->hasRole($role_name)) {
                return $user;
            }
        }

        return null;
    }

    /**
     * generate random string of defined length
     *
     * @param int $length
     * @return string
     */
    function randString($length, $prefix = '')
    {
        $str = '';
        $characters = array_merge(range('A', 'Z'), range('a', 'z'), range('0', '9'));
        $max = count($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $rand = mt_rand(0, $max);
            $str .= $characters[$rand];
        }
        return $prefix . $str;
    }
    
}
?>
