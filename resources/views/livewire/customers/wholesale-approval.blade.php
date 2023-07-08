<div>
    <div class="overflow-hidden bg-white rounded-md shadow-sm dark:bg-slate-900">
        <div class="flex justify-between items-center py-5 px-4 sm:px-6">
            <div>
                <h3 class="text-lg font-medium leading-6 text-slate-900 dark:text-slate-400">
                    Applicant Information</h3>
                <p class="mt-1 max-w-2xl text-sm text-slate-500">Personal details and application.</p>
            </div>
            <div class="flex items-center space-x-6">
                <div class="-mt-1">
                    <x-input.select
                        id="salesperson_id"
                        name="salesperson_id"
                        wire:change="assignToSalesPerson($event.target.value)"
                    >
                        <option
                            class="px-3"
                            value=""
                        >Choose Sales Person
                        </option>
                        @foreach ($salespeople as $salesperson)
                            <option
                                class="capitalize"
                                value="{{ $salesperson->id }}"
                            >
                                <p class="capitalize">{{ $salesperson->name }}</p>
                            </option>
                        @endforeach
                    </x-input.select>
                </div>
                <button
                    class="button-success"
                    wire:click="approve"
                >approve
                </button>
                <button
                    class="button-danger"
                    wire:click="decline"
                >decline
                </button>
            </div>
        </div>
        <div class="border-t border-slate-200">
            <dl>
                <div
                    class="py-5 px-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 bg-slate-50 dark:bg-slate-950"
                >
                    <dt class="text-sm font-medium text-slate-500 dark:text-slate-400">Full name</dt>
                    <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0 text-slate-900 dark:text-slate-300">
                        {{ ucwords($customer->name) }}</dd>
                </div>
                <div class="py-5 px-4 bg-white sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 dark:bg-slate-800">
                    <dt class="text-sm font-medium text-slate-500 dark:text-slate-400">Company Name</dt>
                    <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0 text-slate-900 dark:text-slate-300">
                        @if ($customer->registered_company_name)
                            {{ ucwords($customer->registered_company_name) }} T/A
                        @endif
                        {{ ucwords($customer->company) }}
                        <p>VAT No.: {{ $customer->vat_number ?? 'No Vat Number' }}</p>
                    </dd>
                </div>
                <div
                    class="py-5 px-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 bg-slate-50 dark:bg-slate-950"
                >
                    <dt class="text-sm font-medium text-slate-500 dark:text-slate-400">Email address</dt>
                    <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0 text-slate-900 dark:text-slate-300">
                        {{ $customer->email }}
                    </dd>
                </div>
                <div class="py-5 px-4 bg-white sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 dark:bg-slate-800">
                    <dt class="text-sm font-medium text-slate-500 dark:text-slate-400">Phone</dt>
                    <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0 text-slate-900 dark:text-slate-300">
                        {{ $customer->phone }} @if ($customer->alt_phone)
                            / {{ $customer->alt_phone }}
                        @endif
                    </dd>
                </div>
                <div
                    class="py-5 px-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 bg-slate-50 dark:bg-slate-950"
                >
                    <dt class="text-sm font-medium text-slate-500 dark:text-slate-400">Addresses</dt>
                    <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0 text-slate-900 dark:text-slate-300">
                        @foreach ($customer->addresses as $address)
                            <div class="py-2">
                                <p>
                                    {{ ucwords($address->line_one) }} {{ ucwords($address->line_two) }}
                                    {{ ucwords($address->suburb) }}
                                    {{ ucwords($address->city) }} {{ ucwords($address->province) }}
                                    {{ $address->postal_code }}
                                </p>
                            </div>
                        @endforeach
                    </dd>
                </div>
                <div class="py-5 px-4 bg-white sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 dark:bg-slate-800">
                    <dt class="text-sm font-medium text-slate-500 dark:text-slate-400">Attachments</dt>
                    <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0 text-slate-900 dark:text-slate-300">
                        <ul
                            class="rounded-md border divide-y divide-slate-200 border-slate-200"
                            role="list"
                        >
                            @if ($customer->id_document)
                                <li class="flex justify-between items-center py-3 pr-4 pl-3 text-sm">
                                    <div class="flex flex-1 items-center w-0">
                                        <!-- Heroicon name: mini/paper-clip -->
                                        <svg
                                            class="flex-shrink-0 w-5 h-5 text-slate-400"
                                            aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20"
                                            fill="currentColor"
                                        >
                                            <path
                                                fill-rule="evenodd"
                                                d="M15.621 4.379a3 3 0 00-4.242 0l-7 7a3 3 0 004.241 4.243h.001l.497-.5a.75.75 0 011.064 1.057l-.498.501-.002.002a4.5 4.5 0 01-6.364-6.364l7-7a4.5 4.5 0 016.368 6.36l-3.455 3.553A2.625 2.625 0 119.52 9.52l3.45-3.451a.75.75 0 111.061 1.06l-3.45 3.451a1.125 1.125 0 001.587 1.595l3.454-3.553a3 3 0 000-4.242z"
                                                clip-rule="evenodd"
                                            />
                                        </svg>
                                        <span class="flex-1 ml-2 w-0 truncate">Director ID Document</span>
                                    </div>
                                    <div class="flex-shrink-0 ml-4">
                                        <a
                                            class="font-medium text-green-600 hover:text-green-500"
                                            href="{{ config('app.frontend_url') . '/storage/' . $customer->id_document }}"
                                            download
                                        >Download</a>
                                    </div>
                                </li>
                            @endif
                            @if ($customer->cipc_documents)
                                <li class="flex justify-between items-center py-3 pr-4 pl-3 text-sm">
                                    <div class="flex flex-1 items-center w-0">
                                        <!-- Heroicon name: mini/paper-clip -->
                                        <svg
                                            class="flex-shrink-0 w-5 h-5 text-slate-400"
                                            aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20"
                                            fill="currentColor"
                                        >
                                            <path
                                                fill-rule="evenodd"
                                                d="M15.621 4.379a3 3 0 00-4.242 0l-7 7a3 3 0 004.241 4.243h.001l.497-.5a.75.75 0 011.064 1.057l-.498.501-.002.002a4.5 4.5 0 01-6.364-6.364l7-7a4.5 4.5 0 016.368 6.36l-3.455 3.553A2.625 2.625 0 119.52 9.52l3.45-3.451a.75.75 0 111.061 1.06l-3.45 3.451a1.125 1.125 0 001.587 1.595l3.454-3.553a3 3 0 000-4.242z"
                                                clip-rule="evenodd"
                                            />
                                        </svg>
                                        <span class="flex-1 ml-2 w-0 truncate">CIPC Documents</span>
                                    </div>
                                    <div class="flex-shrink-0 ml-4">
                                        <a
                                            class="font-medium text-green-600 hover:text-green-500"
                                            href="{{ config('app.frontend_url') . '/storage/' . $customer->cipc_documents }}"
                                            download
                                        >Download</a>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </dd>
                </div>
            </dl>
        </div>
        <div
            class="container grid grid-cols-2 gap-6 p-6 mx-auto w-full bg-white rounded-md lg:grid-cols-4 dark:bg-slate-800"
        >
            @foreach ($customer->businessImages as $image)
                <div class="w-full bg-white rounded-md shadow">
                    <img
                        class="object-cover rounded-md"
                        src="{{ config('app.frontend_url') . '/storage/' . $image->photo }}"
                        alt="image"
                    >
                </div>
            @endforeach
        </div>
    </div>

</div>
