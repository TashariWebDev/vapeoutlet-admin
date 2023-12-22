@php use Carbon\Carbon; @endphp
<div wire:init="getValues">
  <div>
    
    <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">
      <x-stat-container>
        <div class="flex justify-between items-center">
          <div class="flex items-center space-x-3">
            <div class="relative pt-0.5"
                 x-data="{showInfo:false}"
            >
              <button
                  x-on:click="showInfo = !showInfo"
              >
                <svg fill="none"
                     stroke="currentColor"
                     stroke-width="1.5"
                     viewBox="0 0 24 24"
                     xmlns="http://www.w3.org/2000/svg"
                     aria-hidden="true"
                     class="w-4 h-4 stroke-sky-400"
                >
                  <path stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"
                  ></path>
                </svg>
              </button>
              
              <div class="absolute z-50 p-3 w-56 rounded-lg shadow-2xl bg-slate-200 text-slate-900 dark:bg-slate-700 dark:text-slate-300"
                   x-show="showInfo"
              >
                <p class="text-xs">
                  Total Sales less Refunds and Credits
                </p>
              </div>
            </div>
            
            <h3 class="text-lg font-bold leading-6 text-slate-600 dark:text-slate-300">Sales</h3>
            @if( $previous_month_gross_sales  > $gross_sales )
              <svg xmlns="http://www.w3.org/2000/svg"
                   fill="none"
                   viewBox="0 0 24 24"
                   stroke-width="1.5"
                   stroke="currentColor"
                   class="w-6 h-6 stroke-rose-600"
              >
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M2.25 6L9 12.75l4.286-4.286a11.948 11.948 0 014.306 6.43l.776 2.898m0 0l3.182-5.511m-3.182 5.51l-5.511-3.181"
                />
              </svg>
            
            @else
              <svg xmlns="http://www.w3.org/2000/svg"
                   fill="none"
                   viewBox="0 0 24 24"
                   stroke-width="1.5"
                   stroke="currentColor"
                   class="w-6 h-6 stroke-green-600"
              >
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941"
                />
              </svg>
            
            @endif
          </div>
        </div>
        <x-slot:footer>
          <div class="grid grid-cols-1 gap-3 lg:grid-cols-2">
            <div>
              <p class="dark:text-white text-slate-900">{{ Carbon::now()->subMonthNoOverflow()->monthName  }}</p>
              <p class="font-bold text-sky-500">
                {{ number_format($previous_month_gross_sales, 2) ?? '0.00' }}
                
                @if($previous_month_gross_sales > 0)
                  <span class="pl-4 text-xs font-semibold text-slate-800 dark:text-slate-500">
                                        R {{ number_format($previous_month_gross_sales / Carbon::now()->subMonthNoOverflow()->daysInMonth , 2) }}
                                        <span class="text-[8px]">D/AVE</span>
                                    </span>
                @endif
              
              </p>
              <p class="text-xs text-slate-500">
                {{ number_format(ex_vat($previous_month_gross_sales), 2) ?? '0.00' }} excl vat
              </p>
            </div>
            <div>
              <p class="dark:text-white text-slate-900">{{ Carbon::now()->monthName  }}</p>
              <p class="font-bold text-sky-500">
                {{ number_format($gross_sales , 2) ?? '0.00' }}
                
                @if($gross_sales > 0)
                  <span class="pl-4 text-xs font-semibold text-slate-800 dark:text-slate-500">
                                        R {{ number_format($gross_sales / Carbon::now()->day , 2) }}
                                        <span class="text-[8px]">D/AVE</span>
                                    </span>
                @endif
              
              </p>
              <p class="text-xs text-slate-500">
                {{ number_format(ex_vat($gross_sales , 2)) ?? '0.00' }} excl vat
              </p>
            </div>
          </div>
        </x-slot:footer>
      </x-stat-container>
      
      <x-stat-container>
        <div class="flex justify-between items-center">
          <div class="flex items-start space-x-3">
            <div class="relative pt-0.5"
                 x-data="{showInfo:false}"
            >
              <button
                  x-on:click="showInfo = !showInfo"
              >
                <svg fill="none"
                     stroke="currentColor"
                     stroke-width="1.5"
                     viewBox="0 0 24 24"
                     xmlns="http://www.w3.org/2000/svg"
                     aria-hidden="true"
                     class="w-4 h-4 stroke-sky-400"
                >
                  <path stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"
                  ></path>
                </svg>
              </button>
              
              <div class="absolute z-50 p-3 w-56 rounded-lg shadow-2xl bg-slate-200 text-slate-900 dark:bg-slate-700 dark:text-slate-300"
                   x-show="showInfo"
              >
                <p class="text-xs">
                  Total Sales Profit less Refunds, Warranties and Credit Note Profits
                </p>
              </div>
            </div>
            <h3 class="text-lg font-bold leading-6 text-slate-600 dark:text-slate-300">Gross
                                                                                       profit</h3>
            @if( $previous_month_gross_profit > $gross_profit)
              <svg xmlns="http://www.w3.org/2000/svg"
                   fill="none"
                   viewBox="0 0 24 24"
                   stroke-width="1.5"
                   stroke="currentColor"
                   class="w-6 h-6 stroke-rose-600"
              >
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M2.25 6L9 12.75l4.286-4.286a11.948 11.948 0 014.306 6.43l.776 2.898m0 0l3.182-5.511m-3.182 5.51l-5.511-3.181"
                />
              </svg>
            
            @else
              <svg xmlns="http://www.w3.org/2000/svg"
                   fill="none"
                   viewBox="0 0 24 24"
                   stroke-width="1.5"
                   stroke="currentColor"
                   class="w-6 h-6 stroke-green-600"
              >
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941"
                />
              </svg>
            
            @endif
          </div>
          
          <div class="flex items-center space-x-6">
            <h3 class="text-lg font-bold leading-6 text-slate-600 dark:text-slate-300">
              Profit margin
            </h3>
            <p class="dark:text-white text-slate-900">{{ $profit_margin }} %</p>
          </div>
        </div>
        <x-slot:footer>
          <div class="grid grid-cols-1 gap-3 lg:grid-cols-2">
            <div>
              <p class="dark:text-white text-slate-900">{{ Carbon::now()->subMonthNoOverflow()->monthName  }}</p>
              <p class="font-bold text-sky-500">
                {{ number_format($previous_month_gross_profit, 2) ?? '0.00' }}
                
                <span class="pl-4 text-xs font-semibold text-slate-800 dark:text-slate-500">
                                        R {{ number_format($previous_month_gross_profit / Carbon::now()->subMonthNoOverflow()->daysInMonth  , 2) }}
                                        <span class="text-[8px]">D/AVE</span>
                                </span>
              
              </p>
              <p class="text-xs text-slate-500">
                {{ number_format(ex_vat($previous_month_gross_profit), 2) ?? '0.00' }} excl vat
              </p>
            </div>
            <div>
              <p class="dark:text-white text-slate-900">{{ Carbon::now()->monthName  }}</p>
              <p class="font-bold text-sky-500">
                {{ number_format($gross_profit, 2) ?? '0.00' }}
                
                <span class="pl-4 text-xs font-semibold text-slate-800 dark:text-slate-500">
                                        R {{ number_format($gross_profit / Carbon::now()->day  , 2) }}
                                        <span class="text-[8px]">D/AVE</span>
                                </span>
              </p>
              <p class="text-xs text-slate-500">
                {{ number_format(ex_vat($gross_profit), 2) ?? '0.00' }} excl vat
              </p>
            </div>
          </div>
        </x-slot:footer>
      </x-stat-container>
      
      
      <x-stat-container>
        <div class="flex items-center space-x-6">
          <h3 class="text-lg font-bold leading-6 text-slate-600 dark:text-slate-300">Purchases</h3>
          @if( $previousMonthPurchases > $purchases)
            <svg xmlns="http://www.w3.org/2000/svg"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke-width="1.5"
                 stroke="currentColor"
                 class="w-6 h-6 stroke-rose-600"
            >
              <path stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M2.25 6L9 12.75l4.286-4.286a11.948 11.948 0 014.306 6.43l.776 2.898m0 0l3.182-5.511m-3.182 5.51l-5.511-3.181"
              />
            </svg>
          
          @else
            <svg xmlns="http://www.w3.org/2000/svg"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke-width="1.5"
                 stroke="currentColor"
                 class="w-6 h-6 stroke-green-600"
            >
              <path stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941"
              />
            </svg>
          
          @endif
        </div>
        <x-slot:footer>
          <div class="grid grid-cols-1 gap-3 lg:grid-cols-2">
            <div>
              <p class="dark:text-white text-slate-900">{{ Carbon::now()->subMonthNoOverflow()->monthName  }}</p>
              <p class="font-bold text-sky-500">
                {{ number_format($previousMonthPurchases, 2) ?? '0.00' }}
                
                @if($previousMonthPurchases > 0)
                  <span class="pl-4 text-xs font-semibold text-slate-800 dark:text-slate-500">
                                        R {{ number_format($previousMonthPurchases / Carbon::now()->subMonthNoOverflow()->daysInMonth , 2) }}
                                        <span class="text-[8px]">D/AVE</span>
                                    </span>
                @endif
              </p>
              <p class="text-xs text-slate-500">
                {{ number_format(ex_vat($previousMonthPurchases), 2) ?? '0.00' }} excl vat
              </p>
            </div>
            <div>
              <p class="dark:text-white text-slate-900">{{ Carbon::now()->monthName  }}</p>
              <p class="font-bold text-sky-500">
                {{ number_format($purchases, 2) ?? '0.00' }}
                
                @if($purchases > 0)
                  <span class="pl-4 text-xs font-semibold text-slate-800 dark:text-slate-500">
                                        R {{ number_format($purchases / Carbon::now()->day , 2) }}
                                        <span class="text-[8px]">D/AVE</span>
                                    </span>
                @endif
              </p>
              <p class="text-xs text-slate-500">
                {{ number_format(ex_vat($purchases), 2) ?? '0.00' }} excl vat
              </p>
            </div>
          </div>
        </x-slot:footer>
      </x-stat-container>
    </div>
  </div>
  
  <div class="grid grid-cols-1 gap-4 mt-4 lg:grid-cols-3">
    <x-stat-container>
      <div class="flex justify-between items-center space-x-6">
        <div class="flex items-center space-x-6">
          <h3 class="text-lg font-bold leading-6 text-slate-600 dark:text-slate-300">Expenses</h3>
          @if( $previousMonthExpenses > $expenses)
            <svg xmlns="http://www.w3.org/2000/svg"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke-width="1.5"
                 stroke="currentColor"
                 class="w-6 h-6 stroke-rose-600"
            >
              <path stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M2.25 6L9 12.75l4.286-4.286a11.948 11.948 0 014.306 6.43l.776 2.898m0 0l3.182-5.511m-3.182 5.51l-5.511-3.181"
              />
            </svg>
          
          @else
            <svg xmlns="http://www.w3.org/2000/svg"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke-width="1.5"
                 stroke="currentColor"
                 class="w-6 h-6 stroke-green-600"
            >
              <path stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941"
              />
            </svg>
          
          @endif
        </div>
        
        <div>
          <button wire:click="printExpenseReport"
                  class="text-sky-600"
                  wire:loading.class="animate-pulse"
                  wire:target="printExpenseReport"
          >
            <x-icons.report class="w-6 h-6" />
          </button>
        </div>
      </div>
      <x-slot:footer>
        <div class="grid grid-cols-1 gap-3 lg:grid-cols-2">
          <div>
            <p class="dark:text-white text-slate-900">{{ Carbon::now()->subMonthNoOverflow()->monthName  }}</p>
            <p class="font-bold text-sky-500">
              {{ number_format(to_rands($previousMonthExpenses ?? 0), 2) ?? '0.00' }}
              
              @if($previousMonthExpenses > 0)
                <span class="pl-4 text-xs font-semibold text-slate-800 dark:text-slate-500">
                                        R {{ number_format(to_rands($previousMonthExpenses ?? 0) / Carbon::now()->subMonthNoOverflow()->daysInMonth , 2) }}
                                        <span class="text-[8px]">D/AVE</span>
                                    </span>
              @endif
            </p>
          </div>
          <div>
            <p class="dark:text-white text-slate-900">{{ Carbon::now()->monthName  }}</p>
            <p class="font-bold text-sky-500">
              {{ number_format(to_rands($expenses),2) ?? '0.00' }}
              
              @if($expenses > 0)
                <span class="pl-4 text-xs font-semibold text-slate-800 dark:text-slate-500">
                                        R {{ number_format(to_rands($expenses / Carbon::now()->day),2) ?? '0.00' }}
                                        <span class="text-[8px]">D/AVE</span>
                                    </span>
              @endif
            </p>
          </div>
        </div>
      </x-slot:footer>
    </x-stat-container>
    
    <x-stat-container>
      <div class="flex justify-between items-center space-x-6">
        <div class="flex items-center space-x-6">
          <h3 class="text-lg font-bold leading-6 text-slate-600 dark:text-slate-300">Refunds</h3>
          @if( (0 - $previous_month_total_refunds) > (0 - $total_refunds))
            <svg xmlns="http://www.w3.org/2000/svg"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke-width="1.5"
                 stroke="currentColor"
                 class="w-6 h-6 stroke-rose-600"
            >
              <path stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M2.25 6L9 12.75l4.286-4.286a11.948 11.948 0 014.306 6.43l.776 2.898m0 0l3.182-5.511m-3.182 5.51l-5.511-3.181"
              />
            </svg>
          @else
            <svg xmlns="http://www.w3.org/2000/svg"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke-width="1.5"
                 stroke="currentColor"
                 class="w-6 h-6 stroke-green-600"
            >
              <path stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941"
              />
            </svg>
          
          @endif
        </div>
        
        <div>
          <button wire:click="print('refund')"
                  class="text-sky-600"
                  wire:loading.class="animate-pulse"
                  wire:target="print('refund')"
          >
            <x-icons.report class="w-6 h-6" />
          </button>
        </div>
      </div>
      <x-slot:footer>
        <div class="grid grid-cols-1 gap-3 lg:grid-cols-2">
          <div>
            <p class="dark:text-white text-slate-900">{{ Carbon::now()->subMonthNoOverflow()->monthName  }}</p>
            <p class="font-bold text-sky-500">
              {{ number_format(to_rands(0 - $previous_month_total_refunds ?? 0), 2) ?? '0.00' }}
              
              @if(0 - $previous_month_total_refunds > 0)
                <span class="pl-4 text-xs font-semibold text-slate-800 dark:text-slate-500">
                                        R {{ number_format(to_rands(0 - $previous_month_total_refunds ?? 0) / Carbon::now()->subMonthNoOverflow()->daysInMonth , 2) }}
                                        <span class="text-[8px]">D/AVE</span>
                                    </span>
              @endif
            </p>
          </div>
          <div>
            <p class="dark:text-white text-slate-900">{{ Carbon::now()->monthName  }}</p>
            <p class="font-bold text-sky-500">
              {{ number_format(to_rands(0 - $total_refunds),2) ?? '0.00' }}
              
              @if(0 - $total_refunds > 0)
                <span class="pl-4 text-xs font-semibold text-slate-800 dark:text-slate-500">
                                        R {{ number_format(to_rands(0 - $total_refunds / Carbon::now()->day),2) ?? '0.00' }}
                                        <span class="text-[8px]">D/AVE</span>
                                    </span>
              @endif
            </p>
          </div>
        </div>
      </x-slot:footer>
    </x-stat-container>
    
    <x-stat-container>
      <div class="flex justify-between items-center space-x-6">
        <div class="flex items-center space-x-6">
          <h3 class="text-lg font-bold leading-6 text-slate-600 dark:text-slate-300">Warranties</h3>
          @if( (0 - $previous_month_total_warranties) > (0 - $total_warranties))
            <svg xmlns="http://www.w3.org/2000/svg"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke-width="1.5"
                 stroke="currentColor"
                 class="w-6 h-6 stroke-rose-600"
            >
              <path stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M2.25 6L9 12.75l4.286-4.286a11.948 11.948 0 014.306 6.43l.776 2.898m0 0l3.182-5.511m-3.182 5.51l-5.511-3.181"
              />
            </svg>
          
          @else
            <svg xmlns="http://www.w3.org/2000/svg"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke-width="1.5"
                 stroke="currentColor"
                 class="w-6 h-6 stroke-green-600"
            >
              <path stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941"
              />
            </svg>
          
          @endif
        </div>
        
        <div>
          <button wire:click="print('warranty')"
                  class="text-sky-600"
                  wire:loading.class="animate-pulse"
                  wire:target="print('warranty')"
          >
            <x-icons.report class="w-6 h-6" />
          </button>
        </div>
      </div>
      <x-slot:footer>
        <div class="grid grid-cols-1 gap-3 lg:grid-cols-2">
          <div>
            <p class="dark:text-white text-slate-900">{{ Carbon::now()->subMonthNoOverflow()->monthName  }}</p>
            <p class="font-bold text-sky-500">
              {{ number_format(to_rands(0 - $previous_month_total_warranties ?? 0), 2) ?? '0.00' }}
              
              @if(0 - $previous_month_total_warranties > 0)
                <span class="pl-4 text-xs font-semibold text-slate-800 dark:text-slate-500">
                                        R {{ number_format(to_rands(0 - $previous_month_total_warranties ?? 0) / Carbon::now()->subMonthNoOverflow()->daysInMonth , 2) }}
                                        <span class="text-[8px]">D/AVE</span>
                                    </span>
              @endif
            </p>
          </div>
          <div>
            <p class="dark:text-white text-slate-900">{{ Carbon::now()->monthName  }}</p>
            <p class="font-bold text-sky-500">
              {{ number_format(to_rands(0 - $total_warranties),2) ?? '0.00' }}
              
              @if(0 - $total_warranties > 0)
                <span class="pl-4 text-xs font-semibold text-slate-800 dark:text-slate-500">
                                        R {{ number_format(to_rands(0 - $total_warranties / Carbon::now()->day),2) ?? '0.00' }}
                                        <span class="text-[8px]">D/AVE</span>
                                    </span>
              @endif
            </p>
          </div>
        </div>
      </x-slot:footer>
    </x-stat-container>
    
    <x-stat-container>
      <div class="flex justify-between items-center space-x-6">
        <div class="flex items-center space-x-6">
          <h3 class="text-lg font-bold leading-6 text-slate-600 dark:text-slate-300">Credits</h3>
          @if( (0 - $previous_month_total_credits) > (0 - $total_credits))
            <svg xmlns="http://www.w3.org/2000/svg"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke-width="1.5"
                 stroke="currentColor"
                 class="w-6 h-6 stroke-rose-600"
            >
              <path stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M2.25 6L9 12.75l4.286-4.286a11.948 11.948 0 014.306 6.43l.776 2.898m0 0l3.182-5.511m-3.182 5.51l-5.511-3.181"
              />
            </svg>
          
          @else
            <svg xmlns="http://www.w3.org/2000/svg"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke-width="1.5"
                 stroke="currentColor"
                 class="w-6 h-6 stroke-green-600"
            >
              <path stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941"
              />
            </svg>
          
          @endif
        </div>
        
        <div>
          <button wire:click="printCurrentCreditReport"
                  class="text-sky-600"
                  wire:loading.class="animate-pulse"
                  wire:target="printCurrentCreditReport"
          >
            <x-icons.report class="w-6 h-6" />
          </button>
        </div>
      </div>
      <x-slot:footer>
        <div class="grid grid-cols-1 gap-3 lg:grid-cols-2">
          <div>
            <p class="dark:text-white text-slate-900">{{ Carbon::now()->subMonthNoOverflow()->monthName  }}</p>
            <p class="font-bold text-sky-500">
              {{ number_format(to_rands(0 - $previous_month_total_credits ?? 0), 2) ?? '0.00' }}
              
              @if(0 - $previous_month_total_credits > 0)
                <span class="pl-4 text-xs font-semibold text-slate-800 dark:text-slate-500">
                                        R {{ number_format(to_rands(0 - $previous_month_total_credits ?? 0) / Carbon::now()->subMonthNoOverflow()->daysInMonth , 2) }}
                                        <span class="text-[8px]">D/AVE</span>
                                    </span>
              @endif
            </p>
          </div>
          <div>
            <p class="dark:text-white text-slate-900">{{ Carbon::now()->monthName  }}</p>
            <p class="font-bold text-sky-500">
              {{ number_format(to_rands(0 - $total_credits),2) ?? '0.00' }}
              
              @if(0 - $total_credits > 0)
                <span class="pl-4 text-xs font-semibold text-slate-800 dark:text-slate-500">
                                        R {{ number_format(to_rands(0 - $total_credits / Carbon::now()->day),2) ?? '0.00' }}
                                        <span class="text-[8px]">D/AVE</span>
                                    </span>
              @endif
            </p>
          </div>
        </div>
      </x-slot:footer>
    </x-stat-container>
    
    
    <x-stat-container>
      <div class="flex justify-between">
        <h3 class="text-lg font-bold leading-6 text-slate-600 dark:text-slate-300">Stock value</h3>
        <button wire:click="printStockReport"
                class="text-sky-600"
                wire:loading.class="animate-pulse"
                wire:target="printStockReport"
        >
          <x-icons.report class="w-6 h-6" />
        </button>
      </div>
      <x-slot:footer>
        <div class="flex justify-between items-center">
          <div>
            <p class="dark:text-white text-slate-900">{{ Carbon::today()->toDateString()  }}</p>
            <div class="flex items-baseline space-x-3">
              <p class="font-bold text-sky-500">
                {{ number_format(to_rands($this->stockValue ?? 0), 2) }}
              </p>
              <p class="text-xs text-slate-500">
                {{ number_format(to_rands(ex_vat($this->stockValue ?? 0)), 2) ?? '0.00' }} (ex vat)
              </p>
            </div>
          </div>
          <button wire:click="getStockValue">
            <x-icons.refresh
                class="w-4 h-4 text-sky-500"
                wire:target="getStockValue"
                wire:loading.class="animate-spin-slow"
            />
          </button>
        </div>
      </x-slot:footer>
    </x-stat-container>
  
  </div>
  
  
  <div class="grid grid-cols-1 gap-3 py-6 lg:grid-cols-3">
    
    <div class="flex col-span-1 items-center h-20 border-b lg:col-span-3 border-slate-500">
      <h2 class="font-bold text-slate-500">Financial Reports</h2>
    </div>
    
    <div class="p-2 bg-white rounded-md dark:bg-slate-800">
      <livewire:reports.sales-report />
    </div>
    
    <div class="p-2 bg-white rounded-md dark:bg-slate-800">
      <livewire:reports.gross-profit-report />
    </div>
    
    <div class="p-2 bg-white rounded-md dark:bg-slate-800">
      <livewire:reports.debtor-report />
    </div>
    
    <div class="p-2 bg-white rounded-md dark:bg-slate-800">
      <livewire:reports.expense-report />
    </div>
    
    <div class="p-2 bg-white rounded-md dark:bg-slate-800">
      <livewire:reports.transaction-report />
    </div>
    
    <div class="p-2 bg-white rounded-md dark:bg-slate-800">
      <livewire:reports.payment-report />
    </div>
    
    <div class="p-2 bg-white rounded-md dark:bg-slate-800">
      <livewire:reports.credit-report />
    </div>
    
    <div class="p-2 bg-white rounded-md dark:bg-slate-800">
      <livewire:reports.discount-report />
    </div>
    
    <div class="flex col-span-1 items-center h-20 border-b lg:col-span-3 border-slate-500">
      <h2 class="font-bold text-slate-500">Inventory Reports</h2>
    </div>
    
    <div class="p-2 bg-white rounded-md dark:bg-slate-800">
      <livewire:reports.creditors-report />
    </div>
    
    <div class="p-2 bg-white rounded-md dark:bg-slate-800">
      <livewire:reports.purchase-report />
    </div>
    
    <div class="p-2 bg-white rounded-md dark:bg-slate-800">
      <livewire:reports.stock-report />
    </div>
    
    <div class="p-2 bg-white rounded-md dark:bg-slate-800">
      <livewire:reports.variances-report />
    </div>
    
    <div>
      <div class="p-2 bg-white rounded-md dark:bg-slate-800">
        <livewire:reports.product-sales-by-volume-report />
      </div>
    </div>
  
  </div>
  
  <div class="grid grid-cols-1 lg:grid-cols-3">
    @if($productVolumes)
      <div class="p-4 mt-3 w-full bg-white rounded-lg shadow dark:text-white text-slate-900 dark:bg-slate-900">
        @php
          $totalProductVolume = [];
        @endphp
        @foreach($productVolumes as $brand => $products)
          <div class="mb-2">
            @php
              $totalProductVolume[] = $products->sum('volume');
            @endphp
            <div class="px-1 mb-2 rounded bg-slate-100 dark:bg-slate-950">
              <p class="font-extrabold">{{$brand}}</p>
            </div>
            @foreach($products as $key => $product)
              <div class="flex justify-between px-2">
                <div class="flex-1 font-semibold text-[12px]">
                  {{$product['name']}}
                </div>
                <div class="font-bold text-right w-[20px] text-[12px]">
                  {{$product['volume']}}
                </div>
              </div>
              @if($loop->last)
                <div class="flex justify-end py-2 px-2 my-2 border-t">
                  <p class="font-bold text-right w-[20px] text-[12px]"> {{  $products->sum('volume')}}</p>
                </div>
              @endif
            @endforeach
            
            
            @if($loop->last)
              <div class="flex justify-between p-2 bg-slate-100 dark:bg-slate-950">
                <div>
                  <p class="font-bold text-right whitespace-nowrap w-[20px] text-[12px]">
                    Total Monthly units
                  </p>
                </div>
                <div>
                  <p class="font-bold text-right w-[20px] text-[12px]">{{ array_sum($totalProductVolume) }}</p>
                </div>
              </div>
              <div class="flex justify-between p-2 bg-slate-100 dark:bg-slate-950">
                <div>
                  <p class="font-bold text-right whitespace-nowrap w-[20px] text-[12px]">
                    Average units per day
                  </p>
                </div>
                <div>
                  <p class="font-bold text-right w-[20px] text-[12px]">
                    {{ number_format(array_sum($totalProductVolume) / Carbon::now()->subMonthNoOverflow()->daysInMonth,0) }}
                  </p>
                </div>
              </div>
              <div class="flex justify-between p-2 bg-slate-100 dark:bg-slate-950">
                <div>
                  <p class="font-bold text-right whitespace-nowrap w-[20px] text-[12px]">
                    Average gp per unit
                  </p>
                </div>
                <div>
                  <p class="font-extrabold text-right whitespace-nowrap text-[12px]">
                    R {{ number_format($gross_profit / array_sum($totalProductVolume),2)  }}
                  </p>
                </div>
              </div>
            @endif
          </div>
        @endforeach
      </div>
    @endif
  </div>

</div>
