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
                    should the columns be nullable with a sensible default?
                
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

               - create credit note from existing order
               - add date range for all reports

### FEATURES

        - Bundle (combos) Products
            how will this be handled per location?
        - Mailchimp API

### FUTURE (LOW PRIORITY OR BEYOND SCOPE)

        - picklist scanning

        - discount report

        - supplier return reports

        - build api
