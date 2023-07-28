<template>
    <DashboardLayout title="Editar Cotización">
        <Toast v-if="toast" v-model="toast" :message="messageResource" />

        <form
            @submit.prevent="submit"
            class="w-full bg-white border border-slate-200 rounded-md shadow-xl"
        >
            <div
                class="flex items-center justify-start bg-slate-200 px-4 py-2 space-x-2 text-xs"
            >
                <label class="capitalize text-sm">
                    <b> {{ __("edit quote") }} </b>
                </label>
            </div>
            <div class="flex flex-col space-y-2 p-4 mb-2 lg:mb-0 last:mb-0">
                <h1
                    class="first-letter:capitalize lowercase text-md text-slate-800 font-bold"
                >
                    {{ __("loading data") }}
                </h1>
                <div
                    class="grid grid-cols-1 gap-x-3 lg:grid-cols-2 mb-2 lg:mb-0 last:mb-0"
                >
                    <div class="mb-2 last:mb-0 first-letter:capitalize">
                        <label
                            for="ruc"
                            class="first-letter:capitalize lowercase text-sm"
                            >{{ __("ruc") }}</label
                        >
                        <form @submit.prevent="searchCustomerByRuc('alert')">
                            <div class="relative">
                                <div class="w-full">
                                    <div class="flex">
                                        <input
                                            v-model="formSearchCustomer.ruc"
                                            type="text"
                                            name="ruc"
                                            class="flex w-full bg-white text-sm border border-slate-300 rounded-tl-md rounded-bl-md shadow placeholder:capitalize"
                                            :placeholder="__('ruc')"
                                            autofocus
                                            autocomplete="off"
                                        />

                                        <button
                                            type="submit"
                                            class="inline-flex bg-blue-600 border border-blue-700 shadow px-3 py-1 text-xs uppercase"
                                        >
                                            <div
                                                class="flex items-center content-center space-x-2"
                                            >
                                                <Icon
                                                    src="search"
                                                    class="text-white pt-1 w-3 h-3"
                                                />
                                            </div>
                                        </button>
                                        <button
                                            @click.prevent="show = true"
                                            class="inline-flex rounded-tr-md rounded-br-md bg-green-600 border border-green-700 shadow px-3 py-1 text-xs uppercase"
                                        >
                                            <div
                                                class="flex items-center content-center space-x-2"
                                            >
                                                <Icon
                                                    src="add"
                                                    class="text-white pt-1 w-3 h-3"
                                                />
                                            </div>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <transition name="fade">
                            <p
                                v-if="form.errors.customer_id"
                                class="text-xs text-red-500"
                            >
                                {{ form.errors.customer_id }}
                            </p>
                        </transition>

                        <ul
                            class="flex-wrap text-xs text-slate-400 mt-2 list-disc list-inside"
                        >
                            <li class="first-letter:capitalize lowercase">
                                {{ __("enter the customer's ruc") }}
                            </li>
                        </ul>
                    </div>
                    <div class="mb-2 last:mb-0 first-letter:capitalize"></div>
                </div>

                <div
                    class="grid grid-cols-1 gap-x-3 lg:grid-cols-2 mb-2 lg:mb-0 last:mb-0"
                >
                    <div class="mb-2 last:mb-0 first-letter:capitalize">
                        <label class="first-letter:capitalize text-sm">{{
                            __("customer data")
                        }}</label>
                        <div class="border border-slate-300 p-2 rounded-md">
                            <label class="capitalize text-sm"
                                ><b> {{ __("name") }} </b>:
                                {{ formSearchCustomer.name }}
                            </label>
                            <br />
                            <label class="capitalize text-sm"
                                ><b> {{ __("address") }} </b>:
                                {{ formSearchCustomer.address }}
                            </label>
                        </div>
                    </div>
                    <div class="mb-2 last:mb-0 first-letter:capitalize">
                        <label
                            for="registration_date"
                            class="first-letter:capitalize lowercase text-sm"
                            >{{ __("registration date") }}</label
                        >
                        <input
                            v-model="form.registration_date"
                            type="date"
                            name="registration_date"
                            class="w-full bg-white text-sm border border-slate-300 rounded-md shadow placeholder:capitalize"
                            autofocus
                        />
                        <transition name="fade">
                            <p
                                v-if="form.errors.registration_date"
                                class="text-xs text-red-500"
                            >
                                {{ form.errors.registration_date }}
                            </p>
                        </transition>
                        <ul
                            class="flex-wrap text-xs text-slate-400 mt-2 list-disc list-inside"
                        >
                            <li class="first-letter:capitalize lowercase">
                                {{ __("enter the date of quotation") }}
                            </li>
                        </ul>
                    </div>
                </div>

                <div
                    class="grid grid-cols-1 gap-x-3 lg:grid-cols-2 mb-2 lg:mb-0 last:mb-0"
                >
                    <div class="mb-2 last:mb-0 first-letter:capitalize">
                        <label
                            for="type_of_transport"
                            class="lowercase text-sm"
                            >{{ __("type of transport") }}</label
                        >

                        <div class="w-full">
                            <Multiselect
                                v-model="form.type_of_transport"
                                :options="type_of_transport"
                                :clearOnSearch="false"
                                :clearOnSelect="false"
                                :searchable="true"
                                :createTag="true"
                                class="capitalize placeholder:capitalize"
                                :placeholder="__('choose an option')"
                            />

                            <transition name="fade">
                                <p
                                    v-if="form.errors.type_of_transport"
                                    class="text-xs text-red-500"
                                >
                                    {{ form.errors.type_of_transport }}
                                </p>
                            </transition>

                            <ul
                                class="flex-wrap text-xs text-slate-400 mt-2 list-disc list-inside"
                            >
                                <li class="first-letter:capitalize lowercase">
                                    {{ __("choose the type of transport") }}
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="mb-2 last:mb-0 first-letter:capitalize">
                        <label for="cargo_type" class="lowercase text-sm">{{
                            __("cargo type")
                        }}</label>

                        <div class="w-full">
                            <Multiselect
                                v-model="form.cargo_type"
                                :options="cargo_type"
                                :clearOnSearch="false"
                                :clearOnSelect="false"
                                :searchable="true"
                                :createTag="true"
                                class="capitalize placeholder:capitalize"
                                :placeholder="__('choose an option')"
                                :disabled="detailsCharge.length > 0"
                            />

                            <transition name="fade">
                                <p
                                    v-if="form.errors.cargo_type"
                                    class="text-xs text-red-500"
                                >
                                    {{ form.errors.cargo_type }}
                                </p>
                            </transition>

                            <ul
                                class="flex-wrap text-xs text-slate-400 mt-2 list-disc list-inside"
                            >
                                <li class="first-letter:capitalize lowercase">
                                    {{ __("choose the type of cargo") }}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-x-3 lg:grid-cols-2 mb-4">
                    <div class="first-letter:capitalize">
                        <label
                            for="containerized_cargo_type"
                            class="first-letter:capitalize lowercase text-sm"
                            >{{ __("containerized cargo type") }}</label
                        >

                        <div class="w-full">
                            <Multiselect
                                v-model="form.containerized_cargo_type"
                                :options="containerized_cargo_type"
                                :clearOnSearch="false"
                                :clearOnSelect="false"
                                :searchable="true"
                                :createTag="true"
                                class="capitalize placeholder:capitalize"
                                :disabled="form.cargo_type !== 'Contenerizada'"
                                :placeholder="__('choose an option')"
                            />

                            <transition name="fade">
                                <p
                                    v-if="form.errors.containerized_cargo_type"
                                    class="text-xs text-red-500"
                                >
                                    {{ form.errors.containerized_cargo_type }}
                                </p>
                            </transition>

                            <ul
                                class="flex-wrap text-xs text-slate-400 mt-2 list-disc list-inside"
                            >
                                <li class="first-letter:capitalize lowercase">
                                    {{
                                        __(
                                            "if you chose the type of containerized cargo, choose the type that corresponds to the containerized cargo"
                                        )
                                    }}
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="first-letter:capitalize">
                        <label for="incoterm" class="capitalize text-sm">{{
                            __("incoterm")
                        }}</label>

                        <Multiselect
                            v-model="form.incoterm"
                            :options="incoterm"
                            :clearOnSearch="false"
                            :clearOnSelect="false"
                            :searchable="true"
                            :createTag="true"
                            class="capitalize placeholder:capitalize"
                            :placeholder="__('choose an option')"
                        />

                        <transition name="fade">
                            <p
                                v-if="form.errors.incoterm"
                                class="text-xs text-red-500"
                            >
                                {{ form.errors.incoterm }}
                            </p>
                        </transition>

                        <ul
                            class="flex-wrap text-xs text-slate-400 mt-2 list-disc list-inside"
                        >
                            <li class="first-letter:capitalize lowercase">
                                {{ __("choose incoterm options") }}
                            </li>
                        </ul>
                    </div>
                </div>

                <hr class="my-8 -mx-3 border-t border-gray-200" />

                <h1
                    class="my-10 first-letter:capitalize lowercase text-md text-slate-800 font-bold"
                >
                    {{ __("load detail") }}
                </h1>

                <div class="grid grid-cols-1 gap-x-3 lg:grid-cols-2 mb-4">
                    <div
                        class="mb-2 last:mb-0 first-letter:capitalize lowercase text-sm"
                    >
                        <label
                            for="cargo_name"
                            class="first-letter:capitalize lowercase text-sm"
                            >{{ __("cargo name") }}</label
                        >

                        <input
                            v-model="newDetailChargeData.cargoName"
                            type="text"
                            name="cargo_name"
                            class="w-full bg-white text-sm border border-slate-300 rounded-md shadow placeholder:capitalize"
                            :placeholder="__('cargo name')"
                            autofocus
                            autocomplete="off"
                        />

                        <transition name="fade">
                            <p
                                v-if="newDetailChargeErrors.cargoName.alert"
                                class="text-xs text-red-500"
                            >
                                {{ newDetailChargeErrors.cargoName.message }}
                            </p>
                        </transition>

                        <ul
                            class="flex-wrap text-xs text-slate-400 mt-2 list-disc list-inside"
                        >
                            <li class="first-letter:capitalize lowercase">
                                {{ __("detail the product to be mobilized") }}
                            </li>
                        </ul>
                    </div>
                    <div
                        class="mb-2 last:mb-0 first-letter:capitalize lowercase text-sm"
                    >
                        <label for="number_of_containers">{{
                            __("amount of charge")
                        }}</label>

                        <div class="flex space-x-2">
                            <input
                                v-model="newDetailChargeData.amountOfCharge"
                                type="number"
                                name="number_of_containers"
                                class="flex w-full bg-white text-sm border border-slate-300 rounded-md shadow placeholder:capitalize"
                                :placeholder="__('amount of charge')"
                                autofocus
                                min="0"
                                autocomplete="off"
                            />

                            <button
                                type="button"
                                class="inline-flex rounded-tr-md rounded-br-md bg-slate-700 text-slate-200 border border-slate-800 rounded-md font-bold shadow px-3 py-1 text-xs text-center uppercase"
                                :disabled="
                                    form.cargo_type.length === 0 ||
                                    newDetailChargeData.cargoName === ''
                                "
                                @click="addDetailCharge"
                            >
                                {{ __("add") }}
                            </button>
                        </div>

                        <transition name="fade">
                            <p
                                v-if="
                                    newDetailChargeErrors.amountOfCharge.alert
                                "
                                class="text-xs text-red-500"
                            >
                                {{
                                    newDetailChargeErrors.amountOfCharge.message
                                }}
                            </p>
                        </transition>

                        <transition name="fade">
                            <p
                                v-if="form.errors.details_charge"
                                class="text-xs text-red-500"
                            >
                                {{ form.errors.details_charge }}
                            </p>
                        </transition>

                        <ul
                            class="flex-wrap text-xs text-slate-400 mt-2 list-disc list-inside"
                        >
                            <li class="first-letter:capitalize lowercase">
                                {{
                                    __(
                                        "enter the number of load(s) or package(s)"
                                    )
                                }}
                            </li>
                        </ul>
                    </div>
                </div>

                <div
                    v-show="
                        form.cargo_type === 'Suelta' ||
                        form.cargo_type === 'Granel'
                    "
                    class="grid grid-cols-1 gap-x-3 lg:grid-cols-2 mb-2 lg:mb-0 last:mb-0"
                >
                    <div class="first-letter:capitalize mb-2 lg:mb-0 last:mb-0">
                        <div
                            class="mb-2 lg:mb-0 last:mb-0 first-letter:capitalize lowercase text-sm"
                        >
                            <label>{{ __("weight") }}</label>
                            <div class="border border-slate-300 p-2 rounded-md">
                                <div
                                    class="mb-2 first-letter:capitalize lowercase text-sm"
                                >
                                    <label
                                        for="unit_of_weight_measurement"
                                        class="first-letter:capitalize lowercase text-sm"
                                        >{{ __("unit of measurement") }}</label
                                    >

                                    <div class="w-full">
                                        <Multiselect
                                            v-model="
                                                newDetailChargeData.unitOfWeightMeasurement
                                            "
                                            :options="
                                                unit_of_weight_measurement
                                            "
                                            :clearOnSearch="false"
                                            :clearOnSelect="false"
                                            :searchable="true"
                                            :createTag="true"
                                            class="capitalize placeholder:capitalize"
                                            :placeholder="
                                                __('choose an option')
                                            "
                                        />
                                    </div>
                                    <transition name="fade">
                                        <p
                                            v-if="
                                                newDetailChargeErrors
                                                    .unitOfWeightMeasurement
                                                    .alert
                                            "
                                            class="text-xs text-red-500"
                                        >
                                            {{
                                                newDetailChargeErrors
                                                    .unitOfWeightMeasurement
                                                    .message
                                            }}
                                        </p>
                                    </transition>
                                </div>

                                <div
                                    class="mb-2 first-letter:capitalize lowercase text-sm"
                                >
                                    <label
                                        for="weight"
                                        class="first-letter:capitalize lowercase text-sm"
                                        >{{ __("count") }}</label
                                    >

                                    <input
                                        v-model="newDetailChargeData.weight"
                                        type="number"
                                        name="weight"
                                        class="w-full bg-white text-sm border border-slate-300 rounded-md shadow placeholder:capitalize"
                                        :placeholder="__('weight')"
                                        autofocus
                                        autocomplete="off"
                                        min="0"
                                    />

                                    <transition name="fade">
                                        <p
                                            v-if="
                                                newDetailChargeErrors.weight
                                                    .alert
                                            "
                                            class="text-xs text-red-500"
                                        >
                                            {{
                                                newDetailChargeErrors.weight
                                                    .message
                                            }}
                                        </p>
                                    </transition>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        class="mb-2 lg:mb-0 last:mb-0 first-letter:capitalize lowercase text-sm"
                    >
                        <label>{{ __("measures") }}</label>
                        <div class="border border-slate-300 p-2 rounded-md">
                            <div
                                class="mb-2 first-letter:capitalize lowercase text-sm"
                            >
                                <label
                                    for="unit_of_length_measurement"
                                    class="first-letter:capitalize lowercase text-sm"
                                    >{{ __("unit of measurement") }}</label
                                >
                                <Multiselect
                                    v-model="
                                        newDetailChargeData.unitOfLengthMeasurement
                                    "
                                    :options="unit_of_length_measurement"
                                    :clearOnSearch="false"
                                    :clearOnSelect="false"
                                    :searchable="true"
                                    :createTag="true"
                                    class="capitalize placeholder:capitalize"
                                    :placeholder="__('choose an option')"
                                />
                                <transition name="fade">
                                    <p
                                        v-if="
                                            newDetailChargeErrors
                                                .unitOfLengthMeasurement.alert
                                        "
                                        class="text-xs text-red-500"
                                    >
                                        {{
                                            newDetailChargeErrors
                                                .unitOfLengthMeasurement.message
                                        }}
                                    </p>
                                </transition>
                            </div>
                            <div
                                class="grid grid-cols-1 gap-x-3 lg:grid-cols-3 mb-2 lg:mb-0 last:mb-0"
                            >
                                <div
                                    class="mb-2 first-letter:capitalize lowercase text-sm"
                                >
                                    <label
                                        for="length"
                                        class="first-letter:capitalize lowercase text-sm"
                                        >{{ __("length") }}</label
                                    >

                                    <input
                                        v-model="newDetailChargeData.length"
                                        type="number"
                                        name="length"
                                        class="w-full bg-white text-sm border border-slate-300 rounded-md shadow placeholder:capitalize"
                                        :placeholder="__('length')"
                                        autofocus
                                        autocomplete="off"
                                        min="0"
                                    />

                                    <transition name="fade">
                                        <p
                                            v-if="
                                                newDetailChargeErrors.length
                                                    .alert
                                            "
                                            class="text-xs text-red-500"
                                        >
                                            {{
                                                newDetailChargeErrors.length
                                                    .message
                                            }}
                                        </p>
                                    </transition>
                                </div>
                                <div
                                    class="mb-2 first-letter:capitalize lowercase text-sm"
                                >
                                    <label
                                        for="width"
                                        class="first-letter:capitalize lowercase text-sm"
                                        >{{ __("width") }}</label
                                    >

                                    <input
                                        v-model="newDetailChargeData.width"
                                        type="number"
                                        name="width"
                                        class="w-full bg-white text-sm border border-slate-300 rounded-md shadow placeholder:capitalize"
                                        :placeholder="__('width')"
                                        autofocus
                                        autocomplete="off"
                                        min="0"
                                    />

                                    <transition name="fade">
                                        <p
                                            v-if="
                                                newDetailChargeErrors.width
                                                    .alert
                                            "
                                            class="text-xs text-red-500"
                                        >
                                            {{
                                                newDetailChargeErrors.width
                                                    .message
                                            }}
                                        </p>
                                    </transition>
                                </div>
                                <div
                                    class="mb-2 first-letter:capitalize lowercase text-sm"
                                >
                                    <label
                                        for="high"
                                        class="first-letter:capitalize lowercase text-sm"
                                        >{{ __("high") }}</label
                                    >

                                    <input
                                        v-model="newDetailChargeData.high"
                                        type="number"
                                        name="high"
                                        class="w-full bg-white text-sm border border-slate-300 rounded-md shadow placeholder:capitalize"
                                        :placeholder="__('high')"
                                        autofocus
                                        autocomplete="off"
                                        min="0"
                                    />

                                    <transition name="fade">
                                        <p
                                            v-if="
                                                newDetailChargeErrors.high.alert
                                            "
                                            class="text-xs text-red-500"
                                        >
                                            {{
                                                newDetailChargeErrors.high
                                                    .message
                                            }}
                                        </p>
                                    </transition>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <SummaryTable
                    :loose-cargo="
                        form.cargo_type === 'Suelta' ||
                        form.cargo_type === 'Granel'
                    "
                    :details-charge="detailsCharge"
                    :cargo-type="form.cargo_type"
                    ref="summaryTable"
                />

                <div class="mt-6"></div>

                <br />

                <hr class="border-t border-gray-200 my-8 -mx-3" />

                <h1
                    class="my-10 first-letter:capitalize lowercase text-md text-slate-800 font-bold"
                >
                    {{ __("type of service") }}
                </h1>

                <ServiceTable
                    :details-service="detailsService"
                    ref="serviceTable"
                />
                <transition name="fade">
                    <p
                        v-if="form.errors.details_service"
                        class="text-xs text-red-500"
                    >
                        {{ form.errors.details_service }}
                    </p>
                </transition>

                <br />

                <hr class="border-t border-gray-200 my-8 -mx-3" />

                <h1
                    class="my-10 first-letter:capitalize lowercase text-md text-slate-800 font-bold"
                >
                    {{ __("additional information") }}
                </h1>

                <div
                    class="grid grid-cols-1 gap-x-3 lg:grid-cols-2 mb-2 lg:mb-0 last:mb-0"
                >
                    <div class="first-letter:capitalize mb-2 lg:mb-0 last:mb-0">
                        <div
                            class="mb-2 lg:mb-0 last:mb-0 first-letter:capitalize lowercase text-sm"
                        >
                            <div class="border border-slate-300 p-2 rounded-md">
                                <div
                                    class="mb-2 first-letter:capitalize lowercase text-sm"
                                >
                                    <label
                                        for="international_freight_information"
                                        class="first-letter:capitalize lowercase text-sm"
                                        >{{
                                            __(
                                                "international freight information"
                                            )
                                        }}</label
                                    >
                                    <input
                                        v-model="
                                            form.international_freight_information
                                        "
                                        type="text"
                                        name="international_freight_information"
                                        class="w-full bg-white text-sm border border-slate-300 rounded-md shadow placeholder:capitalize"
                                        :placeholder="
                                            __(
                                                'international freight information'
                                            )
                                        "
                                        autofocus
                                        autocomplete="off"
                                    />
                                    <transition name="fade">
                                        <p
                                            v-if="
                                                form.errors
                                                    .international_freight_information
                                            "
                                            class="text-xs text-red-500"
                                        >
                                            {{
                                                form.errors
                                                    .international_freight_information
                                            }}
                                        </p>
                                    </transition>
                                </div>

                                <div
                                    class="mb-2 first-letter:capitalize lowercase text-sm"
                                >
                                    <label
                                        for="additional_information"
                                        class="first-letter:capitalize lowercase text-sm"
                                        >{{
                                            __("additional information")
                                        }}</label
                                    >
                                    <input
                                        v-model="form.additional_information"
                                        type="text"
                                        name="additional_information"
                                        class="w-full bg-white text-sm border border-slate-300 rounded-md shadow placeholder:capitalize"
                                        :placeholder="
                                            __('additional information')
                                        "
                                        autofocus
                                        autocomplete="off"
                                    />
                                    <transition name="fade">
                                        <p
                                            v-if="
                                                form.errors
                                                    .additional_information
                                            "
                                            class="text-xs text-red-500"
                                        >
                                            {{
                                                form.errors
                                                    .additional_information
                                            }}
                                        </p>
                                    </transition>
                                </div>

                                <div
                                    class="mb-2 first-letter:capitalize lowercase text-sm"
                                >
                                    <label
                                        for="transit_time"
                                        class="first-letter:capitalize lowercase text-sm"
                                        >{{ __("transit time") }}</label
                                    >
                                    <div class="flex">
                                        <div class="relative w-full">
                                            <input
                                                v-model="form.transit_time"
                                                type="number"
                                                name="transit_time"
                                                class="w-full bg-white text-sm text-center border border-slate-300 rounded-md shadow placeholder:capitalize"
                                                :placeholder="
                                                    __('transit time')
                                                "
                                                autofocus
                                                autocomplete="off"
                                                min="1"
                                                max="60"
                                            />
                                            <span
                                                class="absolute inset-y-0 right-0 flex items-center pr-10 text-md text-gray-500"
                                                >{{ __("days") }}</span
                                            >
                                        </div>
                                    </div>

                                    <transition name="fade">
                                        <p
                                            v-if="form.errors.transit_time"
                                            class="text-xs text-red-500"
                                        >
                                            {{ form.errors.transit_time }}
                                        </p>
                                    </transition>
                                </div>

                                <div
                                    class="flex space-x-2 mb-2 first-letter:capitalize lowercase text-sm"
                                >
                                    <label
                                        for="quote_validity"
                                        class="first-letter:capitalize lowercase text-sm"
                                        >{{ __("quote validity") }}</label
                                    >
                                    <div
                                        class="grid grid-cols-1 gap-x-3 lg:grid-cols-3 mb-2 lg:mb-0 last:mb-0"
                                    >
                                        <div
                                            class="mb-2 first-letter:capitalize lowercase text-sm"
                                        >
                                            <div class="flex">
                                                <div class="relative w-full">
                                                    <input
                                                        v-model="
                                                            form.quote_validity
                                                        "
                                                        type="number"
                                                        name="quote_validity"
                                                        class="w-full bg-white text-sm border border-slate-300 rounded-md shadow placeholder:capitalize"
                                                        :placeholder="
                                                            __('quote_validity')
                                                        "
                                                        autofocus
                                                        autocomplete="off"
                                                        min="0"
                                                    />
                                                    <span
                                                        class="absolute inset-y-0 right-0 flex items-center pr-10 text-md text-gray-500"
                                                        >{{ __("days") }}</span
                                                    >
                                                </div>
                                                <div
                                                    class="flex-inline mb-2 first-letter:capitalize lowercase text-sm text-center justify-center items-center"
                                                >
                                                    {{ quoteValidity }}
                                                </div>
                                            </div>

                                            <transition name="fade">
                                                <p
                                                    v-if="
                                                        form.errors
                                                            .quote_validity
                                                    "
                                                    class="text-xs text-red-500"
                                                >
                                                    {{
                                                        form.errors
                                                            .quote_validity
                                                    }}
                                                </p>
                                            </transition>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        class="mb-2 lg:mb-0 last:mb-0 first-letter:capitalize lowercase text-md"
                    >
                        <div class="border border-slate-300 p-2 rounded-md">
                            <div
                                class="overflow-auto border border-slate-200 rounded my-4"
                            >
                                <table class="border-collapse w-full text-md">
                                    <tbody class="bg-white">
                                        <tr>
                                            <td
                                                colspan="7"
                                                class="border border-slate-200 px-3 py-1 text-center first-letter:capitalize lowercase"
                                            >
                                                <b> {{ __("subtotal0") }} </b>
                                            </td>
                                            <td
                                                class="border border-slate-200 px-3 py-1 text-center"
                                            >
                                                <b>
                                                    $
                                                    {{ subtotal0 }}
                                                </b>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td
                                                colspan="7"
                                                class="border border-slate-200 px-3 py-1 text-center first-letter:capitalize lowercase"
                                            >
                                                <b> {{ __("subtotal12") }} </b>
                                            </td>
                                            <td
                                                class="border border-slate-200 px-3 py-1 text-center"
                                            >
                                                <b>
                                                    $
                                                    {{ subtotal12 }}
                                                </b>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td
                                                colspan="7"
                                                class="border border-slate-200 px-3 py-1 text-center uppercase"
                                            >
                                                <b> iva 12% </b>
                                            </td>
                                            <td
                                                class="border border-slate-200 px-3 py-1 text-center"
                                            >
                                                <b> $ {{ iva12 }} </b>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td
                                                colspan="7"
                                                class="border border-slate-200 px-3 py-1 text-center first-letter:capitalize lowercase"
                                            >
                                                <b> total </b>
                                            </td>
                                            <td
                                                class="border border-slate-200 px-3 py-1 text-center"
                                            >
                                                <b> $ {{ total }} </b>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div
                class="flex items-center justify-end bg-slate-200 px-4 py-2 space-x-2 text-xs"
            >
                <button
                    class="bg-slate-700 text-slate-200 border border-slate-800 rounded-md shadow px-3 py-2 uppercase font-bold"
                >
                    {{ __("edit") }}
                </button>

                <Link
                    :href="route('quotes.index')"
                    class="bg-slate-50 border border-slate-300 rounded-md shadow px-3 py-2 uppercase font-bold"
                >
                    {{ __("back") }}
                </Link>
            </div>
        </form>
        <transition name="fade">
            <Modal v-if="show" @close="show = false" />
        </transition>
    </DashboardLayout>
</template>

<style scoped>
.opacity-enter-active,
.opacity-leave-active {
    transition: all 300ms ease;
    opacity: 1;
}

.opacity-enter-from,
.opacity-leave-to {
    opacity: 0;
}
</style>

<script>
import { defineComponent, ref, toRef } from "vue";
import { Link, useForm } from "@inertiajs/inertia-vue3";
import DashboardLayout from "@/Layouts/DashboardLayout";
import DataTable from "./DataTable";
import SummaryTable from "./SummaryTable";
import Modal from "./Modal";
import ServiceTable from "./ServiceTable";
import Multiselect from "@vueform/multiselect";
import Card from "./Card";
import Icon from "@/Components/Icon";
import axios from "axios";
import Toast from "@/Components/Toast.vue";

export default defineComponent({
    props: {
        quote: Object,
        count: Object,
        perPage: Number,
        search: String,
    },

    components: {
        DashboardLayout,
        Link,
        DataTable,
        Multiselect,
        Card,
        Icon,
        Toast,
        SummaryTable,
        ServiceTable,
        Modal,
    },

    data() {
        return {
            currentDate: new Date().toISOString().split("T")[0],
            form: useForm({
                type_of_transport: new String(),
                cargo_type: new String(),
                containerized_cargo_type: new String(),
                incoterm: new String(),
                customer_id: new String(),
                registration_date: new Date().toISOString().split("T")[0],
                details_charge: new Array(),
                details_service: new Array(),
                subtotal_12: new Number(),
                subtotal_0: new Number(),
                iva: new Number(),
                total: new Number(),
                international_freight_information: new String(),
                additional_information: new String(),
                transit_time: new Number(),
                quote_validity: new Number(),
            }),
            formSearchCustomer: useForm({
                ruc: new String(),
                name: new String(),
                address: new String(),
            }),
            newDetailChargeData: {
                cargoName: new String(),
                amountOfCharge: new Number(),
                unitOfWeightMeasurement: new String(),
                weight: new Number(),
                unitOfLengthMeasurement: new String(),
                length: new Number(),
                width: new Number(),
                high: new Number(),
            },
            newDetailChargeErrors: {
                cargoName: {
                    alert: false,
                    message: "",
                },
                amountOfCharge: {
                    alert: false,
                    message: "",
                },
                unitOfWeightMeasurement: {
                    alert: false,
                    message: "",
                },
                weight: {
                    alert: false,
                    message: "",
                },
                unitOfLengthMeasurement: {
                    alert: false,
                    message: "",
                },
                length: {
                    alert: false,
                    message: "",
                },
                width: {
                    alert: false,
                    message: "",
                },
                high: {
                    alert: false,
                    message: "",
                },
            },
            modal: {
                show: false,
                type: new String(),
            },
            type_of_transport: ["Marítimo", "Aéreo", "Terrestre"],
            cargo_type: ["Suelta", "Granel", "Contenerizada"],
            containerized_cargo_type: [
                "DRY-VAN 20",
                "DRY-VAN 40 HC",
                "BREAKBULK",
                "REEFER 20",
                "REEFER 40",
                "OPEN SIDE",
                "OPEN TOP",
                "FLAT RACK",
                "CISTERNA",
            ],
            incoterm: [
                "Exw - Puesto en fabrica",
                "Fob - Libre al costado del buque",
            ],
            unit_of_weight_measurement: ["KG", "LB", "TON"],
            unit_of_length_measurement: ["M", "CM"],
            toast: false,
            messageResource: "",
            detailsService: [],
            detailsCharge: [],
            show: false,
        };
    },
    computed: {
        weight: function () {
            return this.newDetailChargeData.unitOfWeightMeasurement === "KG"
                ? this.newDetailChargeData.weight / 1000
                : this.newDetailChargeData.unitOfWeightMeasurement === "LB"
                ? this.newDetailChargeData.weight / 2205
                : this.newDetailChargeData.unitOfWeightMeasurement === "TON"
                ? this.newDetailChargeData.weight
                : "";
        },
        volumen: function () {
            return this.newDetailChargeData.unitOfLengthMeasurement === "CM"
                ? (this.newDetailChargeData.width *
                      this.newDetailChargeData.length *
                      this.newDetailChargeData.high) /
                      100
                : this.newDetailChargeData.unitOfLengthMeasurement === "M"
                ? this.newDetailChargeData.width *
                  this.newDetailChargeData.length *
                  this.newDetailChargeData.high
                : "";
        },
        subtotal0: function () {
            const detailsService0 = this.detailsService.filter(
                (item) => item.type_of_service === "Sin IVA"
            );

            return detailsService0.reduce(
                (sum, item) => sum + item.subtotal,
                0
            );
        },
        subtotal12: function () {
            const detailsService12 = this.detailsService.filter(
                (item) => item.type_of_service !== "Sin IVA"
            );

            return detailsService12.reduce(
                (sum, item) => sum + item.subtotal,
                0
            );
        },
        iva12: function () {
            return this.subtotal12 * 0.12;
        },
        total: function () {
            return this.subtotal0 + this.subtotal12 + this.iva12;
        },
        quoteValidity: function () {
            const rdate = new Date(this.form.registration_date);
            rdate.setDate(rdate.getDate() + this.form.quote_validity);
            return rdate.toISOString().substr(0, 10);
        },
    },
    methods: {
        submit() {
            // Detalle de carga
            this.form.details_charge = this.detailsCharge;

            // Detalle de servicio
            this.form.details_service = this.detailsService;

            // Subtotales
            this.form.subtotal_0 = this.subtotal0;
            this.form.subtotal_12 = this.subtotal12;
            this.form.total = this.total;

            return this.form.patch(route("quotes.update", this.quote.id), {
                onSuccess: () => this.form.reset(),
            });
        },
        searchCustomerByRuc(alert = "") {
            axios
                .get(
                    "/customers/getCustomerByRuc?ruc=" +
                        this.formSearchCustomer.ruc
                )
                .then((response) => {
                    if (response) {
                        this.form.clearErrors("customer_id");
                        this.form.customer_id = response.data.customer.id;
                        this.formSearchCustomer.ruc =
                            response.data.customer.ruc;
                        this.formSearchCustomer.name =
                            response.data.customer.name +
                            " " +
                            response.data.customer.last_name;
                        this.formSearchCustomer.address =
                            response.data.customer.address;

                        if (alert === "alert") {
                            this.toast = true;
                            this.messageResource = {
                                response:
                                    "Se encontró el cliente con RUC " +
                                    response.data.customer.ruc,
                                operation: 1,
                            };
                        }
                    }
                })
                .catch((error) => {
                    if (this.form.customer_id !== null)
                        this.form.customer_id = null;
                    this.formSearchCustomer.name = "";
                    this.formSearchCustomer.address = "";
                    console.log(error);

                    if (alert === "alert") {
                        this.toast = true;
                        this.messageResource = {
                            response: "No se encontró un cliente con este RUC",
                            operation: 4,
                        };
                    }
                });
        },
        addDetailCharge() {
            if (this.validateDetailCharge()) {
                this.detailsCharge.push({
                    amount_of_charge: this.newDetailChargeData.amountOfCharge,
                    cargo_type: this.form.cargo_type,
                    cargo_name: this.newDetailChargeData.cargoName,
                    unit_of_weight_measurement:
                        this.newDetailChargeData.unitOfWeightMeasurement,
                    weight: this.newDetailChargeData.weight,
                    unit_of_length_measurement:
                        this.newDetailChargeData.unitOfLengthMeasurement,
                    length: this.newDetailChargeData.length,
                    width: this.newDetailChargeData.width,
                    high: this.newDetailChargeData.high,
                    weight_calculated: this.weight,
                    volumen: this.volumen,
                });
                this.emptyInputsDetailCharge();
            }
        },
        emptyInputsDetailCharge() {
            this.newDetailChargeData.cargoName = "";
            this.newDetailChargeData.amountOfCharge = "";
            this.newDetailChargeData.unitOfWeightMeasurement = "";
            this.newDetailChargeData.weight = "";
            this.newDetailChargeData.unitOfLengthMeasurement = "";
            this.newDetailChargeData.length = "";
            this.newDetailChargeData.width = "";
            this.newDetailChargeData.high = "";
        },
        validateDetailCharge() {
            this.resetInputChargeErrors();

            let count = 0;

            // Unidad de medida: Peso
            if (this.newDetailChargeData.cargoName === "") {
                this.newDetailChargeErrors.cargoName.alert = true;
                this.newDetailChargeErrors.cargoName.message =
                    "El campo Nombre de carga no puede ir vacío";
                count++;
            }

            // Cantidad de carga
            if (!this.newDetailChargeData.amountOfCharge > 0) {
                this.newDetailChargeErrors.amountOfCharge.alert = true;
                this.newDetailChargeErrors.amountOfCharge.message =
                    "El campo Cantidad de carga no puede ser cero (0)";
                count++;
            }

            if (
                this.form.cargo_type === "Suelta" ||
                this.form.cargo_type === "Granel"
            ) {
                // Unidad de medida: Peso
                if (this.newDetailChargeData.unitOfWeightMeasurement === "") {
                    this.newDetailChargeErrors.unitOfWeightMeasurement.alert = true;
                    this.newDetailChargeErrors.unitOfWeightMeasurement.message =
                        "El campo Unidad de medida de 'Peso' no puede ir vacío";
                    count++;
                }

                // Peso
                if (!this.newDetailChargeData.weight > 0) {
                    this.newDetailChargeErrors.weight.alert = true;
                    this.newDetailChargeErrors.weight.message =
                        "El campo Peso no puede ser cero (0)";
                    count++;
                }

                // Unidad de medida: Volumen
                if (this.newDetailChargeData.unitOfLengthMeasurement === "") {
                    this.newDetailChargeErrors.unitOfLengthMeasurement.alert = true;
                    this.newDetailChargeErrors.unitOfLengthMeasurement.message =
                        "El campo Unidad de medida de 'Longitud' no puede ir vacío";
                    count++;
                }

                // Largo
                if (!this.newDetailChargeData.length > 0) {
                    this.newDetailChargeErrors.length.alert = true;
                    this.newDetailChargeErrors.length.message =
                        "El campo Largo no puede ser cero (0)";
                    count++;
                }

                // Ancho
                if (!this.newDetailChargeData.width > 0) {
                    this.newDetailChargeErrors.width.alert = true;
                    this.newDetailChargeErrors.width.message =
                        "El campo Ancho no puede ser cero (0)";
                    count++;
                }

                // Alto
                if (!this.newDetailChargeData.high > 0) {
                    this.newDetailChargeErrors.high.alert = true;
                    this.newDetailChargeErrors.high.message =
                        "El campo Alto no puede ser cero (0)";
                    count++;
                }
            }

            return count === 0;
        },
        resetInputChargeErrors() {
            this.newDetailChargeErrors.amountOfCharge.alert = false;
            this.newDetailChargeErrors.unitOfWeightMeasurement.alert = false;
            this.newDetailChargeErrors.weight.alert = false;
            this.newDetailChargeErrors.unitOfLengthMeasurement.alert = false;
            this.newDetailChargeErrors.length.alert = false;
            this.newDetailChargeErrors.width.alert = false;
            this.newDetailChargeErrors.high.alert = false;

            this.newDetailChargeErrors.amountOfCharge.message = "";
            this.newDetailChargeErrors.unitOfWeightMeasurement.message = "";
            this.newDetailChargeErrors.weight.message = "";
            this.newDetailChargeErrors.unitOfLengthMeasurement.message = "";
            this.newDetailChargeErrors.length.message = "";
            this.newDetailChargeErrors.width.message = "";
            this.newDetailChargeErrors.high.message = "";
        },
    },
    mounted() {
        this.formSearchCustomer.ruc = this.quote.customer.ruc;
        this.form.customer_id = this.quote.customer.id;
        this.searchCustomerByRuc("edit");
        this.form.type_of_transport = this.quote.type_of_transport;
        this.form.cargo_type = this.quote.cargo_type;
        this.form.containerized_cargo_type =
            this.quote.containerized_cargo_type;
        this.form.incoterm = this.quote.incoterm;
        this.form.registration_date = this.quote.registration_date;
        this.detailsCharge = this.quote.product_details;
        this.detailsService = this.quote.service_details;
        this.form.international_freight_information =
            this.quote.international_freight_information;
        this.form.additional_information = this.quote.additional_information;
        this.form.transit_time = this.quote.transit_time;
        this.form.quote_validity = this.quote.quote_validity;

        this.newDetailChargeData.cargoName = "";
        this.newDetailChargeData.amountOfCharge = 0;
        this.newDetailChargeData.unitOfWeightMeasurement = "";
        this.newDetailChargeData.weight = 0;
        this.newDetailChargeData.unitOfLengthMeasurement = "";
        this.newDetailChargeData.length = 0;
        this.newDetailChargeData.width = 0;
        this.newDetailChargeData.high = 0;
    },
    close(ruc = "") {
        if (ruc !== "") {
            this.formSearchCustomer.ruc = ruc;
            this.searchCustomerByRuc();
        }
    },
});
</script>

<style src="@vueform/multiselect/themes/default.css"></style>
