<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="initial-scale=1,viewport-fit=cover"
    >
    <meta name="csrf-token"
          content="{{ csrf_token() }}"
    >

    <style>
        *,
        ::before,
        ::after {
            box-sizing: border-box; /* 1 */
            border-width: 0; /* 2 */
            border-style: solid; /* 2 */
            border-color: #e5e7eb; /* 2 */
        }

        ::before,
        ::after {
            --tw-content: '';
        }


        html {
            line-height: 1.5; /* 1 */
            -moz-tab-size: 4; /* 3 */
            tab-size: 4; /* 3 */
            font-family: Inter var, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji"; /* 4 */
        }


        body {
            margin: 0; /* 1 */
            line-height: inherit; /* 2 */
        }

        /*
        1. Add the correct height in Firefox.
        2. Correct the inheritance of border color in Firefox. (https://bugzilla.mozilla.org/show_bug.cgi?id=190655)
        3. Ensure horizontal rules are visible by default.
        */

        hr {
            height: 0; /* 1 */
            color: inherit; /* 2 */
            border-top-width: 1px; /* 3 */
        }


        abbr:where([title]) {
            text-decoration: underline dotted;
        }


        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-size: inherit;
            font-weight: inherit;
        }


        a {
            color: inherit;
            text-decoration: inherit;
        }


        b,
        strong {
            font-weight: bolder;
        }


        code,
        kbd,
        samp,
        pre {
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace; /* 1 */
            font-size: 1em; /* 2 */
        }


        small {
            font-size: 80%;
        }


        sub,
        sup {
            font-size: 75%;
            line-height: 0;
            position: relative;
            vertical-align: baseline;
        }

        sub {
            bottom: -0.25em;
        }

        sup {
            top: -0.5em;
        }


        table {
            text-indent: 0; /* 1 */
            border-color: inherit; /* 2 */
            border-collapse: collapse; /* 3 */
        }


        button,
        input,
        optgroup,
        select,
        textarea {
            font-family: inherit; /* 1 */
            font-size: 100%; /* 1 */
            font-weight: inherit; /* 1 */
            line-height: inherit; /* 1 */
            color: inherit; /* 1 */
            margin: 0; /* 2 */
            padding: 0; /* 3 */
        }


        button,
        select {
            text-transform: none;
        }


        button,
        [type='button'],
        [type='reset'],
        [type='submit'] {
            background-color: transparent; /* 2 */
            background-image: none; /* 2 */
        }

        .container {
            width: 100%;
        }

        @media (min-width: 640px) {

            .container {
                max-width: 640px;
            }
        }

        @media (min-width: 768px) {

            .container {
                max-width: 768px;
            }
        }

        @media (min-width: 1024px) {

            .container {
                max-width: 1024px;
            }
        }

        @media (min-width: 1280px) {

            .container {
                max-width: 1280px;
            }
        }

        @media (min-width: 1536px) {

            .container {
                max-width: 1536px;
            }
        }

        .sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border-width: 0;
        }

        .pointer-events-none {
            pointer-events: none;
        }

        .pointer-events-auto {
            pointer-events: auto;
        }

        .visible {
            visibility: visible;
        }

        .fixed {
            position: fixed;
        }

        .absolute {
            position: absolute;
        }

        .relative {
            position: relative;
        }

        .inset-0 {
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
        }

        .-inset-px {
            top: -1px;
            right: -1px;
            bottom: -1px;
            left: -1px;
        }

        .inset-y-0 {
            top: 0;
            bottom: 0;
        }

        .right-0 {
            right: 0;
        }

        .bottom-0 {
            bottom: 0;
        }

        .top-0 {
            top: 0;
        }

        .left-0 {
            left: 0;
        }

        .z-0 {
            z-index: 0;
        }

        .z-10 {
            z-index: 10;
        }

        .z-\[9998\] {
            z-index: 9998;
        }

        .z-\[9999\] {
            z-index: 9999;
        }

        .z-30 {
            z-index: 30;
        }

        .z-50 {
            z-index: 50;
        }

        .z-40 {
            z-index: 40;
        }

        .z-20 {
            z-index: 20;
        }

        .col-span-2 {
            grid-column: span 2 / span 2;
        }

        .col-span-6 {
            grid-column: span 6 / span 6;
        }

        .col-span-5 {
            grid-column: span 5 / span 5;
        }

        .col-span-4 {
            grid-column: span 4 / span 4;
        }

        .col-span-8 {
            grid-column: span 8 / span 8;
        }

        .col-span-3 {
            grid-column: span 3 / span 3;
        }

        .col-span-1 {
            grid-column: span 1 / span 1;
        }

        .col-span-7 {
            grid-column: span 7 / span 7;
        }

        .m-2 {
            margin: 0.5rem;
        }

        .-m-0\.5 {
            margin: -0.125rem;
        }

        .-m-0 {
            margin: -0px;
        }

        .mx-auto {
            margin-left: auto;
            margin-right: auto;
        }

        .-my-6 {
            margin-top: -1.5rem;
            margin-bottom: -1.5rem;
        }

        .my-8 {
            margin-top: 2rem;
            margin-bottom: 2rem;
        }

        .my-12 {
            margin-top: 3rem;
            margin-bottom: 3rem;
        }

        .ml-3 {
            margin-left: 0.75rem;
        }

        .-ml-px {
            margin-left: -1px;
        }

        .mt-2 {
            margin-top: 0.5rem;
        }

        .mt-16 {
            margin-top: 4rem;
        }

        .mt-6 {
            margin-top: 1.5rem;
        }

        .mt-1 {
            margin-top: 0.25rem;
        }

        .mr-6 {
            margin-right: 1.5rem;
        }

        .mb-1 {
            margin-bottom: 0.25rem;
        }

        .ml-4 {
            margin-left: 1rem;
        }

        .mb-3 {
            margin-bottom: 0.75rem;
        }

        .mb-4 {
            margin-bottom: 1rem;
        }

        .mt-4 {
            margin-top: 1rem;
        }

        .ml-2 {
            margin-left: 0.5rem;
        }

        .-mt-2 {
            margin-top: -0.5rem;
        }

        .-mr-3 {
            margin-right: -0.75rem;
        }

        .mt-10 {
            margin-top: 2.5rem;
        }

        .mt-0\.5 {
            margin-top: 0.125rem;
        }

        .mt-0 {
            margin-top: 0;
        }

        .mt-8 {
            margin-top: 2rem;
        }

        .ml-1 {
            margin-left: 0.25rem;
        }

        .mr-2 {
            margin-right: 0.5rem;
        }

        .ml-12 {
            margin-left: 3rem;
        }

        .-mt-px {
            margin-top: -1px;
        }

        .ml-0 {
            margin-left: 0;
        }

        .-ml-8 {
            margin-left: -2rem;
        }

        .mr-3 {
            margin-right: 0.75rem;
        }

        .mt-3 {
            margin-top: 0.75rem;
        }

        .ml-6 {
            margin-left: 1.5rem;
        }

        .mb-2 {
            margin-bottom: 0.5rem;
        }

        .-ml-1 {
            margin-left: -0.25rem;
        }

        .mb-20 {
            margin-bottom: 5rem;
        }

        .mr-\[10px\] {
            margin-right: 10px;
        }

        .-mt-32 {
            margin-top: -8rem;
        }

        .mt-5 {
            margin-top: 1.25rem;
        }

        .-ml-20 {
            margin-left: -5rem;
        }

        .mb-5 {
            margin-bottom: 1.25rem;
        }

        .-mr-24 {
            margin-right: -6rem;
        }

        .-ml-10 {
            margin-left: -2.5rem;
        }

        .ml-10 {
            margin-left: 2.5rem;
        }

        .-mt-20 {
            margin-top: -5rem;
        }

        .block {
            display: block;
        }

        .flex {
            display: flex;
        }

        .inline-flex {
            display: inline-flex;
        }

        .table {
            display: table;
        }

        .flow-root {
            display: flow-root;
        }

        .grid {
            display: grid;
        }

        .contents {
            display: contents;
        }

        .hidden {
            display: none;
        }

        .h-5 {
            height: 1.25rem;
        }

        .h-3 {
            height: 0.75rem;
        }

        .h-2 {
            height: 0.5rem;
        }

        .h-6 {
            height: 1.5rem;
        }

        .h-full {
            height: 100%;
        }

        .h-7 {
            height: 1.75rem;
        }

        .h-16 {
            height: 4rem;
        }

        .h-8 {
            height: 2rem;
        }

        .h-\[42px\] {
            height: 42px;
        }

        .h-40 {
            height: 10rem;
        }

        .h-48 {
            height: 12rem;
        }

        .h-auto {
            height: auto;
        }

        .h-12 {
            height: 3rem;
        }

        .h-10 {
            height: 2.5rem;
        }

        .h-20 {
            height: 5rem;
        }

        .h-32 {
            height: 8rem;
        }

        .h-24 {
            height: 6rem;
        }

        .h-96 {
            height: 24rem;
        }

        .h-\[188px\] {
            height: 188px;
        }

        .h-4 {
            height: 1rem;
        }

        .h-72 {
            height: 18rem;
        }

        .h-screen {
            height: 100vh;
        }

        .h-\[80px\] {
            height: 80px;
        }

        .h-64 {
            height: 16rem;
        }

        .h-52 {
            height: 13rem;
        }

        .h-14 {
            height: 3.5rem;
        }

        .min-h-screen {
            min-height: 100vh;
        }

        .min-h-full {
            min-height: 100%;
        }

        .w-5 {
            width: 1.25rem;
        }

        .w-3 {
            width: 0.75rem;
        }

        .w-1\/4 {
            width: 25%;
        }

        .w-1\/2 {
            width: 50%;
        }

        .w-3\/4 {
            width: 75%;
        }

        .w-full {
            width: 100%;
        }

        .w-6 {
            width: 1.5rem;
        }

        .w-screen {
            width: 100vw;
        }

        .w-16 {
            width: 4rem;
        }

        .w-8 {
            width: 2rem;
        }

        .w-40 {
            width: 10rem;
        }

        .w-48 {
            width: 12rem;
        }

        .w-0 {
            width: 0;
        }

        .w-1\/5 {
            width: 20%;
        }

        .w-2\/5 {
            width: 40%;
        }

        .w-3\/5 {
            width: 60%;
        }

        .w-64 {
            width: 16rem;
        }

        .w-12 {
            width: 3rem;
        }

        .w-auto {
            width: auto;
        }

        .w-32 {
            width: 8rem;
        }

        .w-24 {
            width: 6rem;
        }

        .w-10 {
            width: 2.5rem;
        }

        .w-20 {
            width: 5rem;
        }

        .w-2\/3 {
            width: 66.666667%;
        }

        .w-4 {
            width: 1rem;
        }

        .w-\[80px\] {
            width: 80px;
        }

        .w-4\/5 {
            width: 80%;
        }

        .w-2 {
            width: 0.5rem;
        }

        .w-96 {
            width: 24rem;
        }

        .w-56 {
            width: 14rem;
        }

        .w-1 {
            width: 0.25rem;
        }

        .w-72 {
            width: 18rem;
        }

        .min-w-0 {
            min-width: 0;
        }

        .min-w-full {
            min-width: 100%;
        }

        .max-w-2xl {
            max-width: 42rem;
        }

        .max-w-full {
            max-width: 100%;
        }

        .max-w-md {
            max-width: 28rem;
        }

        .max-w-sm {
            max-width: 24rem;
        }

        .max-w-none {
            max-width: none;
        }

        .max-w-7xl {
            max-width: 80rem;
        }

        .max-w-xl {
            max-width: 36rem;
        }

        .max-w-6xl {
            max-width: 72rem;
        }

        .max-w-lg {
            max-width: 32rem;
        }

        .max-w-4xl {
            max-width: 56rem;
        }

        .flex-1 {
            flex: 1 1 0;
        }

        .flex-none {
            flex: none;
        }

        .flex-shrink-0 {
            flex-shrink: 0;
        }

        .flex-shrink {
            flex-shrink: 1;
        }

        .flex-grow {
            flex-grow: 1;
        }

        .border-collapse {
            border-collapse: collapse;
        }

        .origin-top-right {
            transform-origin: top right;
        }

        .origin-top-left {
            transform-origin: top left;
        }

        .origin-top {
            transform-origin: top;
        }

        .list-inside {
            list-style-position: inside;
        }

        .list-disc {
            list-style-type: disc;
        }

        .break-before-avoid {
            break-before: avoid;
        }

        .break-before-avoid-page {
            break-before: avoid-page;
        }

        .break-inside-avoid {
            break-inside: avoid;
        }

        .break-inside-avoid-page {
            break-inside: avoid-page;
        }

        .break-after-avoid-page {
            break-after: avoid-page;
        }

        .grid-cols-4 {
            grid-template-columns: repeat(4, minmax(0, 1fr));
        }

        .grid-cols-5 {
            grid-template-columns: repeat(5, minmax(0, 1fr));
        }

        .grid-cols-1 {
            grid-template-columns: repeat(1, minmax(0, 1fr));
        }

        .grid-cols-2 {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .grid-cols-3 {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .grid-cols-6 {
            grid-template-columns: repeat(6, minmax(0, 1fr));
        }

        .grid-cols-12 {
            grid-template-columns: repeat(12, minmax(0, 1fr));
        }

        .flex-col {
            flex-direction: column;
        }

        .flex-wrap {
            flex-wrap: wrap;
        }

        .items-start {
            align-items: flex-start;
        }

        .items-end {
            align-items: flex-end;
        }

        .items-center {
            align-items: center;
        }

        .items-baseline {
            align-items: baseline;
        }

        .items-stretch {
            align-items: stretch;
        }

        .justify-start {
            justify-content: flex-start;
        }

        .justify-end {
            justify-content: flex-end;
        }

        .justify-center {
            justify-content: center;
        }

        .justify-between {
            justify-content: space-between;
        }

        .justify-around {
            justify-content: space-around;
        }

        .justify-evenly {
            justify-content: space-evenly;
        }

        .justify-items-center {
            justify-items: center;
        }

        .gap-6 {
            gap: 1.5rem;
        }

        .gap-2 {
            gap: 0.5rem;
        }

        .gap-4 {
            gap: 1rem;
        }

        .gap-8 {
            gap: 2rem;
        }

        .gap-y-6 {
            row-gap: 1.5rem;
        }

        .gap-y-8 {
            row-gap: 2rem;
        }

        .gap-x-6 {
            -moz-column-gap: 1.5rem;
            column-gap: 1.5rem;
        }

        .gap-y-4 {
            row-gap: 1rem;
        }

        .gap-y-3 {
            row-gap: 0.75rem;
        }

        .gap-x-8 {
            -moz-column-gap: 2rem;
            column-gap: 2rem;
        }

        .gap-x-4 {
            -moz-column-gap: 1rem;
            column-gap: 1rem;
        }

        .gap-x-12 {
            -moz-column-gap: 3rem;
            column-gap: 3rem;
        }

        .gap-y-10 {
            row-gap: 2.5rem;
        }

        .gap-y-0 {
            row-gap: 0;
        }

        .gap-x-24 {
            -moz-column-gap: 6rem;
            column-gap: 6rem;
        }

        .gap-x-16 {
            -moz-column-gap: 4rem;
            column-gap: 4rem;
        }

        .self-center {
            align-self: center;
        }

        .overflow-auto {
            overflow: auto;
        }

        .overflow-hidden {
            overflow: hidden;
        }

        .overflow-visible {
            overflow: visible;
        }

        .overflow-x-auto {
            overflow-x: auto;
        }

        .overflow-y-auto {
            overflow-y: auto;
        }

        .overflow-y-hidden {
            overflow-y: hidden;
        }

        .overflow-y-scroll {
            overflow-y: scroll;
        }

        .whitespace-nowrap {
            white-space: nowrap;
        }

        .whitespace-pre-line {
            white-space: pre-line;
        }

        .break-all {
            word-break: break-all;
        }

        .rounded-md {
            border-radius: 0.375rem;
        }

        .rounded-xl {
            border-radius: 0.75rem;
        }

        .rounded-full {
            border-radius: 9999px;
        }

        .rounded-sm {
            border-radius: 0.125rem;
        }

        .rounded {
            border-radius: 0.25rem;
        }

        .rounded-lg {
            border-radius: 0.5rem;
        }

        .rounded-2xl {
            border-radius: 1rem;
        }

        .rounded-none {
            border-radius: 0;
        }

        .rounded-l-md {
            border-top-left-radius: 0.375rem;
            border-bottom-left-radius: 0.375rem;
        }

        .rounded-r-md {
            border-top-right-radius: 0.375rem;
            border-bottom-right-radius: 0.375rem;
        }

        .rounded-b-xl {
            border-bottom-right-radius: 0.75rem;
            border-bottom-left-radius: 0.75rem;
        }

        .rounded-t {
            border-top-left-radius: 0.25rem;
            border-top-right-radius: 0.25rem;
        }

        .rounded-l-full {
            border-top-left-radius: 9999px;
            border-bottom-left-radius: 9999px;
        }

        .rounded-r-full {
            border-top-right-radius: 9999px;
            border-bottom-right-radius: 9999px;
        }

        .rounded-t-md {
            border-top-left-radius: 0.375rem;
            border-top-right-radius: 0.375rem;
        }

        .rounded-t-xl {
            border-top-left-radius: 0.75rem;
            border-top-right-radius: 0.75rem;
        }

        .rounded-tr-xl {
            border-top-right-radius: 0.75rem;
        }

        .border {
            border-width: 1px;
        }

        .border-2 {
            border-width: 2px;
        }

        .border-t {
            border-top-width: 1px;
        }

        .border-r {
            border-right-width: 1px;
        }

        .border-t-0 {
            border-top-width: 0;
        }

        .border-l {
            border-left-width: 1px;
        }

        .border-t-4 {
            border-top-width: 4px;
        }

        .border-b {
            border-bottom-width: 1px;
        }

        .border-b-2 {
            border-bottom-width: 2px;
        }

        .border-l-4 {
            border-left-width: 4px;
        }

        .border-dashed {
            border-style: dashed;
        }

        .border-none {
            border-style: none;
        }

        .border-slate-300 {
            --tw-border-opacity: 1;
            border-color: rgb(209 213 219 / 1);
        }

        .border-slate-200 {
            --tw-border-opacity: 1;
            border-color: rgb(229 231 235 / 1);
        }

        .border-transparent {
            border-color: transparent;
        }

        .border-sky-900\/10 {
            border-color: rgb(12 74 110 / 0.1);
        }

        .border-slate-400 {
            --tw-border-opacity: 1;
            border-color: rgb(156 163 175 / 1);
        }

        .border-slate-700 {
            --tw-border-opacity: 1;
            border-color: rgb(55 65 81 / 1);
        }

        .border-sky-600 {
            --tw-border-opacity: 1;
            border-color: rgb(2 132 199 / 1);
        }

        .border-slate-500 {
            --tw-border-opacity: 1;
            border-color: rgb(107 114 128 / 1);
        }

        .border-slate-900 {
            --tw-border-opacity: 1;
            border-color: rgb(17 24 39 / 1);
        }

        .border-sky-400 {
            --tw-border-opacity: 1;
            border-color: rgb(56 189 248 / 1);
        }

        .border-black {
            --tw-border-opacity: 1;
            border-color: rgb(0 0 0 / 1);
        }

        .border-purple-600 {
            --tw-border-opacity: 1;
            border-color: rgb(147 51 234 / 1);
        }

        .border-yellow-300 {
            --tw-border-opacity: 1;
            border-color: rgb(253 224 71 / 1);
        }

        .border-yellow-400 {
            --tw-border-opacity: 1;
            border-color: rgb(250 204 21 / 1);
        }

        .border-red-300 {
            --tw-border-opacity: 1;
            border-color: rgb(252 165 165 / 1);
        }

        .border-red-700 {
            --tw-border-opacity: 1;
            border-color: rgb(185 28 28 / 1);
        }

        .border-purple-400 {
            --tw-border-opacity: 1;
            border-color: rgb(192 132 252 / 1);
        }

        .border-green-400 {
            --tw-border-opacity: 1;
            border-color: rgb(74 222 128 / 1);
        }

        .border-green-300 {
            --tw-border-opacity: 1;
            border-color: rgb(134 239 172 / 1);
        }

        .border-indigo-400 {
            --tw-border-opacity: 1;
            border-color: rgb(129 140 248 / 1);
        }

        .border-sky-900 {
            --tw-border-opacity: 1;
            border-color: rgb(12 74 110 / 1);
        }

        .border-slate-800 {
            --tw-border-opacity: 1;
            border-color: rgb(31 41 55 / 1);
        }

        .border-red-400 {
            --tw-border-opacity: 1;
            border-color: rgb(248 113 113 / 1);
        }

        .border-opacity-10 {
            --tw-border-opacity: 0.1;
        }

        .border-opacity-25 {
            --tw-border-opacity: 0.25;
        }

        .bg-white {
            --tw-bg-opacity: 1;
            background-color: rgb(255 255 255 / 1);
        }

        .bg-slate-100 {
            --tw-bg-opacity: 1;
            background-color: rgb(229 231 235 / 1);
        }

        .bg-sky-500 {
            --tw-bg-opacity: 1;
            background-color: rgb(14 165 233 / 1);
        }

        .bg-slate-900 {
            --tw-bg-opacity: 1;
            background-color: rgb(15 23 42 / 1);
        }

        .bg-sky-600 {
            --tw-bg-opacity: 1;
            background-color: rgb(2 132 199 / 1);
        }

        .bg-slate-500 {
            --tw-bg-opacity: 1;
            background-color: rgb(100 116 139 / 1);
        }

        .bg-white\/50 {
            background-color: rgb(255 255 255 / 0.5);
        }

        .bg-sky-600\/60 {
            background-color: rgb(2 132 199 / 0.6);
        }

        .bg-slate-100 {
            --tw-bg-opacity: 1;
            background-color: rgb(241 245 249 / 1);
        }

        .bg-rose-500 {
            --tw-bg-opacity: 1;
            background-color: rgb(244 63 94 / 1);
        }

        .bg-slate-300 {
            --tw-bg-opacity: 1;
            background-color: rgb(203 213 225 / 1);
        }

        .bg-slate-100 {
            --tw-bg-opacity: 1;
            background-color: rgb(243 244 246 / 1);
        }

        .bg-red-600 {
            --tw-bg-opacity: 1;
            background-color: rgb(220 38 38 / 1);
        }

        .bg-slate-800 {
            --tw-bg-opacity: 1;
            background-color: rgb(31 41 55 / 1);
        }

        .bg-slate-900 {
            --tw-bg-opacity: 1;
            background-color: rgb(17 24 39 / 1);
        }

        .bg-white\/60 {
            background-color: rgb(255 255 255 / 0.6);
        }

        .bg-white\/30 {
            background-color: rgb(255 255 255 / 0.3);
        }

        .bg-slate-400 {
            --tw-bg-opacity: 1;
            background-color: rgb(156 163 175 / 1);
        }

        .bg-yellow-300 {
            --tw-bg-opacity: 1;
            background-color: rgb(253 224 71 / 1);
        }

        .bg-slate-500 {
            --tw-bg-opacity: 1;
            background-color: rgb(107 114 128 / 1);
        }

        .bg-slate-100 {
            --tw-bg-opacity: 1;
            background-color: rgb(226 232 240 / 1);
        }

        .bg-slate-700 {
            --tw-bg-opacity: 1;
            background-color: rgb(55 65 81 / 1);
        }

        .bg-red-200 {
            --tw-bg-opacity: 1;
            background-color: rgb(254 202 202 / 1);
        }

        .bg-green-600 {
            --tw-bg-opacity: 1;
            background-color: rgb(22 163 74 / 1);
        }

        .bg-rose-200 {
            --tw-bg-opacity: 1;
            background-color: rgb(254 205 211 / 1);
        }

        .bg-sky-400 {
            --tw-bg-opacity: 1;
            background-color: rgb(56 189 248 / 1);
        }

        .bg-white\/25 {
            background-color: rgb(255 255 255 / 0.25);
        }

        .bg-pink-600 {
            --tw-bg-opacity: 1;
            background-color: rgb(219 39 119 / 1);
        }

        .bg-transparent {
            background-color: transparent;
        }

        .bg-red-700 {
            --tw-bg-opacity: 1;
            background-color: rgb(185 28 28 / 1);
        }

        .bg-slate-600 {
            --tw-bg-opacity: 1;
            background-color: rgb(75 85 99 / 1);
        }

        .bg-slate-800 {
            --tw-bg-opacity: 1;
            background-color: rgb(30 41 59 / 1);
        }

        .bg-yellow-400 {
            --tw-bg-opacity: 1;
            background-color: rgb(250 204 21 / 1);
        }

        .bg-green-500 {
            --tw-bg-opacity: 1;
            background-color: rgb(34 197 94 / 1);
        }

        .bg-slate-300 {
            --tw-bg-opacity: 1;
            background-color: rgb(209 213 219 / 1);
        }

        .bg-white\/70 {
            background-color: rgb(255 255 255 / 0.7);
        }

        .bg-slate-400 {
            --tw-bg-opacity: 1;
            background-color: rgb(148 163 184 / 1);
        }

        .bg-sky-700 {
            --tw-bg-opacity: 1;
            background-color: rgb(3 105 161 / 1);
        }

        .bg-white\/80 {
            background-color: rgb(255 255 255 / 0.8);
        }

        .bg-slate-900\/80 {
            background-color: rgb(17 24 39 / 0.8);
        }

        .bg-green-50 {
            --tw-bg-opacity: 1;
            background-color: rgb(240 253 244 / 1);
        }

        .bg-indigo-50 {
            --tw-bg-opacity: 1;
            background-color: rgb(238 242 255 / 1);
        }

        .bg-slate-50 {
            --tw-bg-opacity: 1;
            background-color: rgb(249 250 251 / 1);
        }

        .bg-clip-text {
            -webkit-background-clip: text;
            background-clip: text;
        }

        .bg-right {
            background-position: right;
        }

        .bg-bottom {
            background-position: bottom;
        }

        .bg-center {
            background-position: center;
        }

        .bg-right-bottom {
            background-position: right bottom;
        }

        .bg-no-repeat {
            background-repeat: no-repeat;
        }

        .bg-origin-content {
            background-origin: content-box;
        }

        .fill-slate-900 {
            fill: #0f172a;
        }

        .fill-white {
            fill: #fff;
        }

        .fill-slate-900 {
            fill: #111827;
        }

        .fill-current {
            fill: currentColor;
        }

        .fill-sky-400 {
            fill: #38bdf8;
        }

        .fill-yellow-300 {
            fill: #fde047;
        }

        .fill-pink-600 {
            fill: #db2777;
        }

        .fill-pink-400 {
            fill: #f472b6;
        }

        .object-cover {
            -o-object-fit: cover;
            object-fit: cover;
        }

        .object-fill {
            -o-object-fit: fill;
            object-fit: fill;
        }

        .object-center {
            -o-object-position: center;
            object-position: center;
        }

        .p-2 {
            padding: 0.5rem;
        }

        .p-4 {
            padding: 1rem;
        }

        .p-1 {
            padding: 0.25rem;
        }

        .p-6 {
            padding: 1.5rem;
        }

        .p-20 {
            padding: 5rem;
        }

        .p-0\.5 {
            padding: 0.125rem;
        }

        .p-0 {
            padding: 0;
        }

        .p-12 {
            padding: 3rem;
        }

        .p-3 {
            padding: 0.75rem;
        }

        .p-8 {
            padding: 2rem;
        }

        .px-4 {
            padding-left: 1rem;
            padding-right: 1rem;
        }

        .py-2 {
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
        }

        .px-2 {
            padding-left: 0.5rem;
            padding-right: 0.5rem;
        }

        .py-16 {
            padding-top: 4rem;
            padding-bottom: 4rem;
        }

        .py-6 {
            padding-top: 1.5rem;
            padding-bottom: 1.5rem;
        }

        .py-3 {
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
        }

        .py-1 {
            padding-top: 0.25rem;
            padding-bottom: 0.25rem;
        }

        .py-4 {
            padding-top: 1rem;
            padding-bottom: 1rem;
        }

        .py-10 {
            padding-top: 2.5rem;
            padding-bottom: 2.5rem;
        }

        .px-6 {
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }

        .px-8 {
            padding-left: 2rem;
            padding-right: 2rem;
        }

        .py-20 {
            padding-top: 5rem;
            padding-bottom: 5rem;
        }

        .px-1 {
            padding-left: 0.25rem;
            padding-right: 0.25rem;
        }

        .py-0\.5 {
            padding-top: 0.125rem;
            padding-bottom: 0.125rem;
        }

        .py-0 {
            padding-top: 0;
            padding-bottom: 0;
        }

        .px-3 {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }

        .px-5 {
            padding-left: 1.25rem;
            padding-right: 1.25rem;
        }

        .py-5 {
            padding-top: 1.25rem;
            padding-bottom: 1.25rem;
        }

        .py-2\.5 {
            padding-top: 0.625rem;
            padding-bottom: 0.625rem;
        }

        .py-12 {
            padding-top: 3rem;
            padding-bottom: 3rem;
        }

        .px-16 {
            padding-left: 4rem;
            padding-right: 4rem;
        }

        .py-8 {
            padding-top: 2rem;
            padding-bottom: 2rem;
        }

        .py-24 {
            padding-top: 6rem;
            padding-bottom: 6rem;
        }

        .px-10 {
            padding-left: 2.5rem;
            padding-right: 2.5rem;
        }

        .py-32 {
            padding-top: 8rem;
            padding-bottom: 8rem;
        }

        .px-20 {
            padding-left: 5rem;
            padding-right: 5rem;
        }

        .px-0 {
            padding-left: 0;
            padding-right: 0;
        }

        .pr-2 {
            padding-right: 0.5rem;
        }

        .pl-10 {
            padding-left: 2.5rem;
        }

        .pt-3 {
            padding-top: 0.75rem;
        }

        .pt-0\.5 {
            padding-top: 0.125rem;
        }

        .pt-0 {
            padding-top: 0;
        }

        .pt-8 {
            padding-top: 2rem;
        }

        .pb-16 {
            padding-bottom: 4rem;
        }

        .pb-6 {
            padding-bottom: 1.5rem;
        }

        .pb-4 {
            padding-bottom: 1rem;
        }

        .pb-2 {
            padding-bottom: 0.5rem;
        }

        .pt-16 {
            padding-top: 4rem;
        }

        .pr-6 {
            padding-right: 1.5rem;
        }

        .pt-2 {
            padding-top: 0.5rem;
        }

        .pb-10 {
            padding-bottom: 2.5rem;
        }

        .pr-1 {
            padding-right: 0.25rem;
        }

        .pt-4 {
            padding-top: 1rem;
        }

        .pr-4 {
            padding-right: 1rem;
        }

        .pb-12 {
            padding-bottom: 3rem;
        }

        .pl-2 {
            padding-left: 0.5rem;
        }

        .pt-5 {
            padding-top: 1.25rem;
        }

        .pt-1 {
            padding-top: 0.25rem;
        }

        .pt-6 {
            padding-top: 1.5rem;
        }

        .pl-4 {
            padding-left: 1rem;
        }

        .pb-24 {
            padding-bottom: 6rem;
        }

        .pt-20 {
            padding-top: 5rem;
        }

        .pb-32 {
            padding-bottom: 8rem;
        }

        .pb-3 {
            padding-bottom: 0.75rem;
        }

        .pt-14 {
            padding-top: 3.5rem;
        }

        .pb-14 {
            padding-bottom: 3.5rem;
        }

        .pt-10 {
            padding-top: 2.5rem;
        }

        .pl-3 {
            padding-left: 0.75rem;
        }

        .pl-1 {
            padding-left: 0.25rem;
        }

        .pr-12 {
            padding-right: 3rem;
        }

        .pl-12 {
            padding-left: 3rem;
        }

        .pt-11 {
            padding-top: 2.75rem;
        }

        .pt-32 {
            padding-top: 8rem;
        }

        .text-left {
            text-align: left;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .align-super {
            vertical-align: super;
        }

        .font-mono {
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
        }

        .font-sans {
            font-family: Inter var, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
        }

        .text-sm {
            font-size: 0.875rem;
            line-height: 1.25rem;
        }

        .text-4xl {
            font-size: 2.25rem;
            line-height: 2.5rem;
        }

        .text-base {
            font-size: 1rem;
            line-height: 1.5rem;
        }

        .text-lg {
            font-size: 1.125rem;
            line-height: 1.75rem;
        }

        .text-xs {
            font-size: 0.75rem;
            line-height: 1rem;
        }

        .text-\[4px\] {
            font-size: 4px;
        }

        .text-\[10px\] {
            font-size: 10px;
        }

        .text-2xl {
            font-size: 1.5rem;
            line-height: 2rem;
        }

        .text-5xl {
            font-size: 3rem;
            line-height: 1;
        }

        .text-\[8px\] {
            font-size: 8px;
        }

        .text-xl {
            font-size: 1.25rem;
            line-height: 1.75rem;
        }

        .text-3xl {
            font-size: 1.875rem;
            line-height: 2.25rem;
        }

        .text-\[12px\] {
            font-size: 12px;
        }

        .text-\[100px\] {
            font-size: 100px;
        }

        .text-\[150px\] {
            font-size: 150px;
        }

        .text-7xl {
            font-size: 4.5rem;
            line-height: 1;
        }

        .text-8xl {
            font-size: 6rem;
            line-height: 1;
        }

        .text-9xl {
            font-size: 8rem;
            line-height: 1;
        }

        .font-medium {
            font-weight: 500;
        }

        .font-bold {
            font-weight: 700;
        }

        .font-semibold {
            font-weight: 600;
        }

        .font-extrabold {
            font-weight: 800;
        }

        .font-thin {
            font-weight: 100;
        }

        .uppercase {
            text-transform: uppercase;
        }

        .capitalize {
            text-transform: capitalize;
        }

        .italic {
            font-style: italic;
        }

        .leading-5 {
            line-height: 1.25rem;
        }

        .leading-7 {
            line-height: 1.75rem;
        }

        .leading-relaxed {
            line-height: 1.625;
        }

        .leading-loose {
            line-height: 2;
        }

        .leading-6 {
            line-height: 1.5rem;
        }

        .leading-none {
            line-height: 1;
        }

        .leading-10 {
            line-height: 2.5rem;
        }

        .leading-8 {
            line-height: 2rem;
        }

        .tracking-tight {
            letter-spacing: -0.025em;
        }

        .tracking-widest {
            letter-spacing: 0.1em;
        }

        .tracking-wider {
            letter-spacing: 0.05em;
        }

        .tracking-wide {
            letter-spacing: 0.025em;
        }

        .text-slate-500 {

            color: rgb(107 114 128 / 1);
        }

        .text-slate-700 {

            color: rgb(55 65 81 / 1);
        }

        .text-sky-500 {

            color: rgb(14 165 233 / 1);
        }

        .text-slate-900 {

            color: rgb(15 23 42 / 1);
        }

        .text-white {

            color: rgb(255 255 255 / 1);
        }

        .text-slate-600 {

            color: rgb(75 85 99 / 1);
        }

        .text-sky-400 {

            color: rgb(56 189 248 / 1);
        }

        .text-slate-400 {

            color: rgb(156 163 175 / 1);
        }

        .text-slate-600 {

            color: rgb(71 85 105 / 1);
        }

        .text-slate-500 {

            color: rgb(100 116 139 / 1);
        }

        .text-blue-600 {

            color: rgb(37 99 235 / 1);
        }

        .text-rose-600 {

            color: rgb(225 29 72 / 1);
        }

        .text-red-600 {

            color: rgb(220 38 38 / 1);
        }

        .text-rose-400 {

            color: rgb(251 113 133 / 1);
        }

        .text-green-600 {

            color: rgb(22 163 74 / 1);
        }

        .text-rose-500 {

            color: rgb(244 63 94 / 1);
        }

        .text-slate-800 {

            color: rgb(31 41 55 / 1);
        }

        .text-transparent {
            color: transparent;
        }

        .text-slate-300 {

            color: rgb(209 213 219 / 1);
        }

        .text-sky-800 {

            color: rgb(7 89 133 / 1);
        }

        .text-slate-200 {

            color: rgb(229 231 235 / 1);
        }

        .text-sky-900 {

            color: rgb(12 74 110 / 1);
        }

        .text-sky-50 {

            color: rgb(240 249 255 / 1);
        }

        .text-sky-200 {

            color: rgb(186 230 253 / 1);
        }

        .text-slate-900 {

            color: rgb(17 24 39 / 1);
        }

        .text-black {

            color: rgb(0 0 0 / 1);
        }

        .text-pink-600 {

            color: rgb(219 39 119 / 1);
        }

        .text-red-900 {

            color: rgb(127 29 29 / 1);
        }

        .text-yellow-300 {

            color: rgb(253 224 71 / 1);
        }

        .text-pink-400 {

            color: rgb(244 114 182 / 1);
        }

        .text-red-700 {

            color: rgb(185 28 28 / 1);
        }

        .text-slate-300 {

            color: rgb(203 213 225 / 1);
        }

        .text-slate-800 {

            color: rgb(30 41 59 / 1);
        }

        .text-sky-700 {

            color: rgb(3 105 161 / 1);
        }

        .text-sky-600 {

            color: rgb(2 132 199 / 1);
        }

        .text-red-200 {

            color: rgb(254 202 202 / 1);
        }

        .text-red-300 {

            color: rgb(252 165 165 / 1);
        }

        .text-slate-400 {

            color: rgb(148 163 184 / 1);
        }

        .text-indigo-600 {

            color: rgb(79 70 229 / 1);
        }

        .text-slate-100 {

            color: rgb(243 244 246 / 1);
        }

        .text-green-700 {

            color: rgb(21 128 61 / 1);
        }

        .text-sky-200\/20 {
            color: rgb(186 230 253 / 0.2);
        }

        .text-sky-100 {

            color: rgb(224 242 254 / 1);
        }

        .text-slate-100 {

            color: rgb(241 245 249 / 1);
        }

        .text-indigo-700 {

            color: rgb(67 56 202 / 1);
        }

        .text-blue-400 {

            color: rgb(96 165 250 / 1);
        }

        .text-sky-300 {

            color: rgb(125 211 252 / 1);
        }

        .text-slate-200 {

            color: rgb(226 232 240 / 1);
        }

        .underline {
            text-decoration-line: underline;
        }

        .line-through {
            text-decoration-line: line-through;
        }

        .decoration-yellow-300 {
            text-decoration-color: #fde047;
        }

        .decoration-wavy {
            text-decoration-style: wavy;
        }

        .underline-offset-4 {
            text-underline-offset: 4px;
        }

        .underline-offset-2 {
            text-underline-offset: 2px;
        }

        .antialiased {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .placeholder-slate-500::-moz-placeholder {

            color: rgb(107 114 128 / 1);
        }

        .placeholder-slate-500::placeholder {

            color: rgb(107 114 128 / 1);
        }

        .placeholder-slate-500::-moz-placeholder {

            color: rgb(100 116 139 / 1);
        }

        .placeholder-slate-500::placeholder {

            color: rgb(100 116 139 / 1);
        }

        .opacity-90 {
            opacity: 0.9;
        }

        .opacity-0 {
            opacity: 0;
        }

        .opacity-100 {
            opacity: 1;
        }

        .opacity-20 {
            opacity: 0.2;
        }

        .opacity-95 {
            opacity: 0.95;
        }

        .shadow-sm {
            box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05);
        }

        .shadow-xl {
            box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
        }

        .shadow-2xl {
            box-shadow: 0 25px 50px -12px rgb(0 0 0 / 0.25);
        }

        .shadow {
            box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
        }

        .shadow-md {
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        }

        .shadow-inner {
            box-shadow: inset 0 2px 4px 0 rgb(0 0 0 / 0.05);

        }

        .shadow-lg {
            box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        }

        .shadow-pink-600 {
            color: #db2777;
        }

        .shadow-slate-300 {
            color: #cbd5e1;
        }

        .shadow-sky-400 {
            color: #38bdf8;
        }

        .shadow-pink-500 {
            color: #ec4899;
        }

        .outline-none {
            outline: 2px solid transparent;
            outline-offset: 2px;
        }

        .outline {
            outline-style: solid;
        }
    </style>

    @if($subject = $attributes->get('subject'))
        <title>{{ $subject }}</title>
    @endif
</head>
<body>
    <div class="container px-2 mx-auto bg-white">
        <div class="flex justify-center items-center p-6 w-full rounded-lg shadow-lg bg-slate-900">
            <div>
                <img src="https://vapeoutlet.co.za/logos/dark.png"
                     alt="Vape Outlet"
                     class="w-auto h-16"
                >
            </div>
        </div>

        <div class="container mx-auto mt-6">
            {{ $slot }}
        </div>

        <div class="container mx-auto mt-6">
            <img src="{{ $bannerUrl }}"
                 alt="Vape Outlet"
                 class="container object-contain mx-auto rounded-lg rounded-t-lg shadow-lg"
            >
        </div>


        <div class="container flex justify-center items-center mx-auto mt-6 h-32 rounded-lg shadow-lg leading-0 bg-slate-900">
            <div class="text-center text-white">
                <p>The Vape Outlet Team</p>
                <p>sales@vapeoutlet.co.za | 069 352 9522</p>
            </div>
        </div>
    </div>
</body>
</html>
