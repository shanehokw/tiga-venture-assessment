# Tiga Venture Assessment

## Setting up the database

1. Make a copy of the .env.exmaple file
2. Modify the database connection settings as required

## Running the application

1. Open up a terminal and run:

```console
composer install
npm install
php artisan serve
```

2. In another terminal run

```console
npm run dev
```

## Requirements

The following requirements were given:

1. User should be able to create a new task, including the following fields

-   Name
-   Description
-   Duedate

2. User should be able to view all tasks created in a list view, showing all the following
   details

-   Name
-   Description
-   Due date
-   Create date
-   Status:
    -   Not urgent
    -   Due soon (Due date is within 7 days)
    -   Overdue

3. User should be able to edit task name, description and due date
4. User should be able to sort by due date or create date
5. User should be able to search based on task name
6. Application should still be performant up to 10s of 1000s rows of data

## Assumptions

1. No fine-grained IAM permissioning, like Task.Create, Task.Edit - any authenticated user can create, edit, view all their tasks

## Workflow

First, I gave the requirements document a read to get an understanding of the application to build. As it was quite straightforward, I had no clarifying questions. Next, I started by drafting the entities of the application. I knew there would be Users and Tasks. Then I considered the relationships of the entities. A user can have many tasks, and inversely, a task belongs to one user. Then, I proceeded with modelling the data. Since status is determined based on the due date, I decided not to set it as a column but rather to compute it programmatically.

```
Task {
    name string
    user_id bigint
    description string
    due_date datetime
    created_at datetime
    updated_at datetime
    deleted_at datetime
}
```

Then, I spent a few days familiarising myself with Laravel. As it is an opionated framework, I look through several articles, sample repositories and watch YouTube videos to get a feel for the project structure and coding style. Thankfully, it follows a similar architectural pattern to what I currently use. I then got to developing. I first focused on rendering some sample data using Inertia + Vue, making sure I was able to get Vue and Laravel to communicate with each other. Then I built out the create and edit pages to make sure that changes I make were persisted to the database.

Finally I tackled the 'should have requirements' like searching and sorting. I also decided to add pagination to the data in order to make sure that the application would still be performant with 10s of 1000s of records.

The goal was to implement a user-friendly and efficient way to sort, search and paginate tasks in a data table. My solution involved leveraging URL query parameters to handle sorting and searching, ensuring a seamless and intuitive user experience while maintaining the state of filters during navigation.

1. Design and User Interaction
   I used a conventional data table with sorting buttons on sortable columns and page numbers below the table. I also included a search bar above the data table.

2. Data Flow and State Management
   When a user clicks a sorting button, searches a term or moves between pages, the relevant states are appended as query parameters (search, orderBy, orderDirection, pageNo) to the URL. This ensures the state is persisted even when users refresh the browser.

3. Server-side handling
   The query parameters are then processed in the controller and passed to the service to perform the appropriate query. The controller then passes the resulting data as props via an Inertia respone to render the results.

## Future Improvements

Due to time limitations, certain efforts were not implemented and left for future improvements. Below is a non-exhaustive list

### 1. Column indexes:

Seeing as there could be a large volume of data, as well as the requirement of searching and sorting. Column indexes can be considered to speed up query times. Potential ones are:

-   GIN index with pg_trgm extension for the name column. This would speed up the search function as it depends on an ILIKE operator.
-   BTREE index on created_at and due_date columns. This would speed up the ordering function as it depends on an ORDER BY expression. This would also be beneficial if in the future there is a requirement for searching tasks within a specific time range.

### 2. Better flexibility for due date

User experience can be improved if tasks can be created without due dates, or with date and time. Current implementation only supports date and is compulsory. On the list view, users may want the option to see only tasks that are overdue/due soon/not urgent

### 3. In-memory cache implementation

In order to further improve performance, an in-memory cache such as Redis can be used to cache responses and saving trips to the database.

### 4. Add logging

Given the time, I would add more/better logging throughout the controller logic. This would make it easier to debug if I need to.
