# WIP

- - -

### STOCK outlets

~~Permission - can transfer stock~~

- create stock transfer and print
- Sales Channel
- warehouse outlets and sales channels
- Branch
- Inventory
- Stock Transfers
- Reporting
- Stock Takes
- Quick Stock Lookup
- Sales Channel
- Point of sale
- Outlet Model

        - create outlet module (model / migrations / livewire-components )

            Relationships:
                - a outlet hasMany stocks
                - a stock belongsTo a outlet
                - an admin belongsToMany a outlet
                - a outlet belongsToMany admins
                - a order belongsTo a outlet
                - a outlet hasMany orders
                - a credit belongsTo a outlet
                - a outlet hasMany credits

            Models: 
                NEW:
                - outlet
                CHANGES:
                  - STOCK
                  - ORDER
                  - CREDIT
                  - ADMIN

            MIGRATIONS:
                NEW:
                 - outlets
                 - admin_outlet (pivot) is default
                CHANGES:
                    - orders outlet_id
                    - credits outlet_id
                    - stocks outlets_id
                    - permissions name


            COMPONENTS/VIEWS
                NEW:
                    - outlet
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
                
        - link stocks to outlet

            Admin must be able to create outlet
            what happens if outlet is disabled/deleted?
            stock must be transfered between outlets
            who will be responsible for transfers?
            should the system request stock automatically based on stock level?
            who approves this


        - link admin to outlet
            - if not linked default (warehouse)
            - super-admin to be able to choose active outlet
                is this handled as a permission?
                can this be manually done?
                who approves this?
                what happens if outlet is disabled/deleted?

        - restrict admins to allocated outlet - default or selectable

        - link order to outlet 
            stock availablity check needs to check against allocated outlet only
            
        - link credit note to outlet ????

        - inventory table
            who gets to view this
            should we have multiple inventory tables
            
    
        - reports per outlet
            do we use the same report and allow selection of outlet
            what if we need a overall report
            performance ? 
                - stock will need to be queried per outlet before processing report

            - sales
            - inventory
            - stock take

        - create stock take module per outlet
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
            how will this be handled per outlet?
        - Mailchimp API

### FUTURE (LOW PRIORITY OR BEYOND SCOPE)

        - picklist scanning

        - discount report

        - supplier return reports

        - build api

    

        - add date to supplier transactions and update label to amount
