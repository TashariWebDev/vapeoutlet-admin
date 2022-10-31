# WIP

- - -

### STOCK LOCATIONS

        - create location module (model / migrations / livewire-components )

            Relationships:
                - a location hasMany stocks
                - a stock belongsTo a location
                - an admin belongsTo a location
                - a location hasMany admins
                - a order belongsTo a location
                - a location hasMany orders
                - a credit belongsTo a location
                - a location hasMany credits
                - a customer belongsTo a location
                - a location hasMany customers

            Models: 
                NEW:
                - LOCATION
                CHANGES:
                  - STOCK
                  - ORDER
                  - CREDIT
                  - ADMIN
                  - CUSTOMER

            MIGRATIONS:
                NEW:
                 - locations
                CHANGES:
                    - customers location_id
                    - admins location_id
                    - orders location_id
                    - credits location_id
                    - stocks locations_id
                    - permissions name


            COMPONENTS/VIEWS
                NEW:
                    - LOCATION
                        - create
                        - update
                        - delete ?? should this be allowed
                CHANGES:
                    - PERMSISSIONS 
                        
                    - ADMINS
                        - create
                        - edit 

                    - CUSTOMERS
                        - create
                        - edit
                        - register
                        - profile

                   - ORDERS
                      - create
                      - edit

                    - CREDITS
                        - create
    
                    - REPORTS
                        - CREATE

                    - INVENTORY
                        - show

                    - CART
                    - CHECKOUT
                    - PAYMENT
            

            seperate data table or existing stock table to link location to stock?
                - seperate
                    higher chances of write errors
                    slower
                - existing
                    better performance
                    how do we update current data
                    should the colums be nullable with a sensible default?
                
        - link stocks to location

            Admin must be able to create location
            what happens if location is disabled/deleted?
            stock must be transfered between locations
            who will be responsible for transfers?
            should the system request stock automatically based on stock level?
            who approves this
            
        - link customer to location
                is a customer auto allocated based on type of customer?
                can this be manually done?
                who approves this?
                what happens if location is disabled/deleted?

        - link admin to location
            - if not linked default (warehouse)
            - super-admin to be able to choose active location
                is this handled as a permission?
                can this be manually done?
                who approves this?
                what happens if location is disabled/deleted?

        - restrict admins to allocated location ??
        - link order to location 
            stock availablity check needs to check against allocated location only
            
        - link credit note to location ????

        - inventory table
            who gets to view this
            should we have multiple inventory tables
            
    
        - reports per location
            do we use the same report and allow selection of location
            what if we need a overall report
            performance ? 
                - stock will need to be queried per location before processing report

            - sales
            - inventory
            - stock take

        - create stock take module per location
            how is adjustments handled?
            
        - how are payments allocated 
            will need to be seperated for reporting

        - can a product be disabled per location?
        
        - Frontend 
            -- cart - product must be picked from specific location
                    - stock availablity must be managed per allocation

# TODO

- - -

### FRONTEND

        - Wholesale application
            customer to complete form on frontend
            when does he submit docs
                - email 
                    - reduces overhead and complexity
                    - reduces storage
                    - prevents data leaks
                    - POPI compliant
                - direct upload
                    - data needs to be stored
                    - adds to storage consumption
                    - what happens if malicious/corrupt files are uploaded?
                    - performance?

### CHANGES

        - Not vat suppliers
        - Reduce order statuses
                - combine warehouse & dispatch
                    when will add waybill?
        - allocation of payments -  how to simplify

### PAIN POINTS/ BUGS

        - how do we prevent users from multi clicking - cause: duplicates

### FEATURES

        - Bundle (combos) Products
            how will this be handled per location?
        - Mailchimp API

### FUTURE (LOW PRIORITY OR BEYOND SCOPE)

        - picklist scanning
            
        - warranty claims

        - discount report

        - supplier return reports

        - build api

### CONSIDERATIONS

    - do we move the system to a mono repo?
        - reduces complexity
        - reduces communication errors
        - what happens during maintenance?
            can it still be managed seperately?
        - reduces duplicate/ redundant code
        - performance???

### UPDATES

- - -

# Warehouse

        - Invoice number not to change or hide credited invoices
        - Credited invoices not to move to the top of list
        - Edited invoices to be highlighted
        - Where to credit delivery
        - Credit in warehouse
        - Credit complete orders or part of it
        - Dispatch details on invoice
        - Customer statement
        - Invoice and packing slip from warehouse

~~Need to see address~~

~~Sales rep to show on order screen and customer screen~~

~~Indicate Wholesale or retail on screen~~

~~search by shop name~~

- - -

# Shanu

        - Paygates
        - Collect from warehouse
        - Edited details need to be shown on invoices

# Faeeza

        - Non-vatable creditors
        - Discounts on invoices

~~Sales by date range~~

~~stock on hand at specific time~~
