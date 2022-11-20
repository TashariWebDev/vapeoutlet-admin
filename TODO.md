# WIP

- - -

### STOCK LOCATIONS

        - create location module (model / migrations / livewire-components )

            Relationships:
                - a location hasMany stocks
                - a stock belongsTo a location
                - an admin belongsToMany a location
                - a location belongsToMany admins
                - a order belongsTo a location
                - a location hasMany orders
                - a credit belongsTo a location
                - a location hasMany credits

            Models: 
                NEW:
                - LOCATION
                CHANGES:
                  - STOCK
                  - ORDER
                  - CREDIT
                  - ADMIN

            MIGRATIONS:
                NEW:
                 - locations
                 - admin_location (pivot) is default
                CHANGES:
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

                   - ORDERS
                      - create
                      - edit

                    - CREDITS
                        - create
    
                    - REPORTS
                        - CREATE

                    - INVENTORY
                        - show
            

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


        - link admin to location
            - if not linked default (warehouse)
            - super-admin to be able to choose active location
                is this handled as a permission?
                can this be manually done?
                who approves this?
                what happens if location is disabled/deleted?

        - restrict admins to allocated location - default or selectable

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

~~Reduce order statuses~~

~~combine warehouse & dispatch~~

~~when will add waybill?~~

~~allocation of payments - how to simplify~~

### PAIN POINTS/ BUGS

~~how do we prevent users from multi clicking - cause: duplicates~~

### FEATURES

        - Bundle (combos) Products
            how will this be handled per location?
        - Mailchimp API

### FUTURE (LOW PRIORITY OR BEYOND SCOPE)

        - picklist scanning

~~warranty claims~~

        - discount report

        - supplier return reports

        - build api

### UPDATES

- - -

# Warehouse

~~Customer statement~~

~~Credit complete orders or part of it~~

~~Invoice number not to change or hide credited invoices~~

~~Edited invoices to be highlighted~~

~~Credited invoices not to move to the top of list~~

~~Where to credit delivery~~

~~Credit in warehouse~~

~~Dispatch details on invoice~~

~~Invoice and packing slip from warehouse~~

~~Need to see address~~

~~Sales rep to show on order screen and customer screen~~

~~Indicate Wholesale or retail on screen~~

~~search by shop name~~

- - -

# Shanu

~~Paygates~~

        - Collect from warehouse

~~Edited details need to be shown on invoices~~

# Faeeza

~~Discounts on invoices~~
- create credit note from existing order
- add date range for all reports

~~add date to transactions~~

~~Non-vatable creditors~~

~~Sales by date range~~

~~stock on hand at specific time~~
