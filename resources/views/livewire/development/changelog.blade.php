<div class="prose prose-sky prose-lg dark:prose-invert">
    <div>
        <div class="py-4">
            <a class="link"
               href="{{ route('dashboard') }}"
            >&larr; Go Back</a>
        </div>
        
        <h1>Change Log</h1>
        
        <h4>
            View our latest updates,fixes and upcoming features
        </h4>
        
        <div class="p-2 my-4 rounded prose-sm">
            <p>
                <span class="font-bold">New:</span> indicates new feature
            </p>
            <p>
                <span class="font-bold">Fix:</span> indicates fix to error or bug
            </p>
            <p>
                <span class="font-bold">Update:</span> indicates improvement or update to existing feature
            </p>
        </div>
        
        <div class="p-2 my-4 rounded prose-sm">
            <h4>Upcoming (work in progress)</h4>
            
            <ul class="list-decimal">
                <li>
                    Complete rewrite of GRV module
                </li>
                <li>
                    Complete rewrite of Credit note module
                </li>
            </ul>
        </div>
        
        <div class="p-2 my-4 rounded prose-sm">
            <time>7 August 2023</time>
            
            <ul class="list-decimal">
                <li>
                    <span class="font-bold">Update:</span>
                    Fix UI on mobile grid on orders index page.
                </li>
                <li>
                    <span class="font-bold">Fix:</span>
                    Adjust UI on pending orders page
                </li>
                <li>
                    <span class="font-bold">Update:</span>
                    Update supplier UI
                </li>
                <li>
                    <span class="font-bold">Update:</span>
                    Add description and date to supplier transactions
                </li>
            </ul>
        </div>
        
        <div class="p-2 my-4 rounded prose-sm">
            <time>2 August 2023</time>
            
            <ul class="list-decimal">
                <li>
                    <span class="font-bold">Update:</span>
                    Make sales channel optional on reports
                </li>
                <li>
                    <span class="font-bold">Fix:</span>
                    Adjust input timing on GRV inputs
                </li>
                <li>
                    <span class="font-bold">Update:</span>
                    Update report dashboard to reflect more accurate sales and GP figures.
                </li>
            </ul>
        </div>
        
        <div class="p-2 my-4 rounded prose-sm">
            <time>31 July 2023</time>
            
            <ul class="list-decimal">
                <li>
                    <span class="font-bold">Update:</span>
                    Add daily average to reports index (expenses, purchases, credits, refunds)
                </li>
                <li>
                    <span class="font-bold">fix:</span>
                    Fix bug where reports dashboard was not taking into account months with 31 days
                </li>
            </ul>
        </div>
        
        <div class="p-2 my-4 rounded prose-sm">
            <time>27 July 2023</time>
            
            <ul class="list-decimal">
                <li>
                    <span class="font-bold">Update:</span>
                    Add click to copy on order show page (customer details and address)
                </li>
                <li>
                    <span class="font-bold">Update:</span>
                    Add tracking number to orders index page
                </li>
                <li>
                    <span class="font-bold">Update:</span>
                    Update report dashboard to reflect more accurate sales and GP figures.
                </li>
            </ul>
        </div>
        
        <div class="p-2 my-4 rounded prose-sm">
            <time>25 July 2023</time>
            
            <ul class="list-decimal">
                <li>
                    <span class="font-bold">Update:</span>
                    Adjust timing on orders search bar
                </li>
            </ul>
        </div>
        
        <div class="p-2 my-4 rounded prose-sm">
            <time>26 July 2023</time>
            
            <ul class="list-decimal">
                <li>
                    <span class="font-bold">Fix:</span>
                    Fix bug when adding a full range of single brand to order or credit, and try and search
                    for the same brand the add product disables as the search does not clear and is still querying
                    the specific brand.
                </li>
            </ul>
        </div>
        
        <div class="p-2 my-4 rounded prose-sm">
            <time>24 July 2023</time>
            
            <ul class="list-decimal">
                <li>
                    <span class="font-bold">Update:</span>
                    Add print functionality to supplier credit module
                </li>
            </ul>
        </div>
        
        <div class="p-2 my-4 rounded prose-sm">
            <time>21 July 2023</time>
            
            <ul class="list-decimal">
                <li>
                    <span class="font-bold">Update:</span>
                    Update core framework Laravel V10.9.0
                </li>
                <li>
                    <span class="font-bold">Update:</span>
                    Add daily average sales + gross profit on reports index page
                </li>
                <li>
                    <span class="font-bold">Update:</span>
                    Update changelog UI
                </li>
                <li>
                    <span class="font-bold">Update:</span>
                    Update warehouse UI
                </li>
            </ul>
        </div>
        
        <div class="p-2 my-4 rounded prose-sm">
            <time>08 July 2023</time>
            
            <ul class="list-decimal">
                <li>
                    <span class="font-bold">Update:</span>
                    Add company name on all reports
                </li>
                
                <li>
                    <span class="font-bold">Fix:</span>
                    Fix totals on purchase report not reflecting foreign currency instead of rands
                </li>
                <li>
                    <span class="font-bold">Fix:</span>
                    Add company name to header
                </li>
            </ul>
        </div>
        
        <div class="p-2 my-4 rounded prose-sm">
            <time>13 July 2023</time>
            
            <ul class="list-decimal">
                <li>
                    <span class="font-bold">New:</span>
                    Add date filter to customer show page to filter transactions by date range.
                </li>
                <li>
                    <span class="font-bold">Update:</span>
                    Add ability to create supplier directly from supplier index screen
                </li>
                <li>
                    <span class="font-bold">Update:</span>
                    Add ability to create purchase directly from supplier index screen
                </li>
                <li>
                    <span class="font-bold">Update:</span>
                    Update Purchase edit UI
                </li>
                <li>
                    <span class="font-bold">Update:</span>
                    Update Supplier index UI
                </li>
                <li>
                    <span class="font-bold">Update:</span>
                    Update Supplier show UI
                </li>
                <li>
                    <span class="font-bold">Update:</span>
                    Update Supplier Credit create UI
                </li>
                <li>
                    <span class="font-bold">Update:</span>
                    Update Supplier Credit edit UI
                </li>
                <li>
                    <span class="font-bold">Fix:</span>
                    Supplier credit line total not automatically updating
                </li>
            </ul>
        </div>
        
        <div class="p-2 my-4 rounded prose-sm">
            <time>08 July 2023</time>
            
            <ul class="list-decimal">
                <li>
                    <span class="font-bold">Update:</span>
                    Adjust button contrast and hover states
                </li>
                <li>
                    <span class="font-bold">Update:</span>
                    Adjust link contrast and hover states
                </li>
            </ul>
        </div>
        
        <div class="p-2 my-4 rounded prose-sm">
            <time>07 July 2023</time>
            
            <ul class="list-decimal">
                <li>
                    <span class="font-bold">Update:</span>
                    Adjust product ordering to group by brand and order by name on product page
                </li>
                <li>
                    <span class="font-bold">Update:</span>
                    Adjust delivery description to truncate and add description on hover on order index page
                </li>
            </ul>
        </div>
        
        <div class="p-2 my-4 rounded prose-sm">
            <time>04 July 2023</time>
            
            <ul class="list-decimal">
                <li>
                    <span class="font-bold">Update:</span>
                    Adjust UI with larger fonts and touch targets
                </li>
            </ul>
        </div>
        
        <div class="p-2 my-4 rounded prose-sm">
            <time>03 July 2023</time>
            
            <ul class="list-decimal">
                <li>
                    <span class="font-bold">Update:</span>
                    improve product index page performance by 100%
                </li>
                <li>
                    <span class="font-bold">Update:</span>
                    reduce product index page queries by 50%
                </li>
                <li>
                    <span class="font-bold">New:</span>
                    Order index page will now autoload new orders without refreshing page
                </li>
                <li>
                    <span class="font-bold">New:</span>
                    Added customer contact details to order screen
                </li>
            </ul>
        </div>
        
        <div class="p-2 my-4 rounded prose-sm">
            <time>02 July 2023</time>
            
            <ul class="list-decimal">
                <li>
                    <span class="font-bold">Fix:</span>
                    remove redundant status filter from cash-up page
                </li>
            </ul>
        </div>
        
        <div class="p-2 my-4 rounded prose-sm">
            <time>22 June 2023</time>
            
            <ul class="list-decimal">
                <li>
                    <span class="font-bold">New:</span> Added change log page
                </li>
                <li>
                    <span class="font-bold">Update:</span>
                    When creating an order & customer has only
                    one address registered. The address is automatically selected
                </li>
                <li>
                    <span class="font-bold">Update:</span>
                    Add customer ID on Customer page for easier tracking
                </li>
                <li>
                    <span class="font-bold">Fix:</span>
                    update admin notifications displaying wrong logo
                </li>
                <li>
                    <span class="font-bold">New:</span>
                    background colour and notification for training
                    environment. (only available on training environment)
                </li>
                <li>
                    <span class="font-bold">Update:</span>
                    Layout of customer transaction view on Orders and Cash Up pages
                </li>
                <li>
                    <span class="font-bold">New:</span> UI on Cash Up page to match Orders page
                </li>
                <li>
                    <span class="font-bold">Fix:</span> Mobile view on Cash Up and Orders pages
                </li>
                <li>
                    <span class="font-bold">New:</span> Quick Notes view on Orders page
                </li>
                <li>
                    <span class="font-bold">New:</span> animation to Auth pages
                </li>
                <li>
                    <span class="font-bold">New:</span> export customers to excel (ADMIN ONLY)
                </li>
                <li>
                    <span class="font-bold">Update:</span>
                    change font size on customer show page - stats to prevent wrapping
                </li>
                <li>
                    <span class="font-bold">Update:</span>
                    change mobile layout on Customer index page
                </li>
            </ul>
        
        </div>
    
    </div>
</div>
