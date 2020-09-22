import {access_server} from '../modules/access_server.js';
import {add_video_cards} from '../modules/add_video_cards.js';

class Pagination {
    constructor(next_page_token, previous_page_token, search_term, number_of_videos, active_page, last_active_page, total_pages, cutoff_point, move_backwards) {
        this._next_page_token = next_page_token;
        this._previous_page_token = previous_page_token;
        this._search_term = search_term;
        this._number_of_videos = number_of_videos;
        this._active_page = active_page;
        this._last_active_page = last_active_page;
        this._total_pages = total_pages;
        this._cutoff_point = cutoff_point;
        this._move_backwards = move_backwards;

        this.page_click = this.page_click.bind(this);
    }

    //Getters and Setters for '_next_page_token'
    set next_page_token(next_page_token) {
        this._next_page_token = next_page_token;
    }

    get next_page_token() {
        return this._next_page_token;
    }

    //Getters and Setters for '_previous_page_token'
    set previous_page_token(previous_page_token) {
        this._previous_page_token = previous_page_token;
    }

    get previous_page_token() {
        return this._previous_page_token;
    }

    //Getters and Setters for '_search_term'
    set search_term(search_term) {
        this._search_term = search_term;
    }

    get search_term() {
        return this._search_term;
    }

    //Getters and Setters for '_number_of_videos'
    set number_of_videos(number_of_videos) {
        this._number_of_videos = number_of_videos;
    }

    get number_of_videos() {
        return this._number_of_videos;
    }

    //Getters and Setters for '_active_page'
    set active_page(active_page) {
        this._active_page = active_page;
    }

    get active_page() {
        return this._active_page;
    }

    //Getters and Setters for '_last_active_page'
    set last_active_page(last_active_page) {
        this._last_active_page = last_active_page;
    }

    get last_active_page() {
        return this._last_active_page;
    }

    //Getters and Setters for '_total_pages'
    set total_pages(total_pages) {
        this._total_pages = total_pages;
    }

    get total_pages() {
        return this._total_pages;
    }

    //Getters and Setters for '_cutoff_point'
    set cutoff_point(cutoff_point) {
        this._cutoff_point = cutoff_point;
    }

    get cutoff_point() {
        return this._cutoff_point;
    }

    //Getters and Setters for '_move_backwards'
    set move_backwards(move_backwards) {
        this._move_backwards = move_backwards;
    }

    get move_backwards() {
        return this._move_backwards;
    }

    async check_pagination_pages() {
        let pagination = $('.pagination').children(`li:not('#previous'):not('#next')`);
        let index;
        let move_by;

        for (let i = 0; i < pagination.length; i++) {
            if ($(pagination[i]).hasClass('active')) {
                index = i;
                this.move_backwards = true;
            }
        }

        //Check if current pagination displays the first page, if so, we
        // won't rearange the pages
        if (parseInt($(pagination[0]).text()) === 1) {
            this.move_backwards = false;
        }

        //If the clicked page exceeds the cutoff point (6th page), we shift
        //the pages forward by x where x is the index - cutoff_point
        if (index > this.cutoff_point) {
            move_by = index - this.cutoff_point;

            this.shift_pagination_pages(pagination, move_by);
        } else if (this.move_backwards) {
            move_by = this.cutoff_point - index;

            this.shift_pagination_pages(pagination, move_by, this.move_backwards);
        }
    }

    async shift_pagination_pages(pagination, move_by, move_backwards) {
        let current_max_page = parseInt($(pagination[pagination.length - 1]).text());
        let current_first_page = parseInt($(pagination[0]).text());

        //Remove old event listeners to prevent event from firing twice
        $('.page').unbind('click', this.page_click);

        //Check if we move pages forward (positive int) or backwards (negative int)
        if (!move_backwards) {
            //Move forwards
            for (let i = 0; i < move_by; i++) {
                if (current_max_page < this.total_pages) {
                    current_max_page++;

                    $(pagination[i]).remove();
                    $('#next').before(`<li class="page-item page"><a class="page-link" href="#">${current_max_page}</a></li>`);
                }
            }
        } else {
            //Move backwards
            for (let i = 0; i < move_by; i++) {
                if (current_first_page > 1) {
                    current_first_page--;

                    //Remove last page
                    $(pagination[pagination.length - 1]).remove();
                    //Add new page at the start
                    $('#previous').after(`<li class="page-item page"><a class="page-link" href="#">${current_first_page}</a></li>`);
                    pagination = $('.pagination').children(`li:not('#previous'):not('#next')`);
                }
            }
        }

        //Add new click event to encompass new elements
        $('.page').click(this.page_click);
    }

    async page_click(e) {
        let target = $(e.currentTarget);

        //Check if the clicked element IS NOT currently active AND IS NOT
        //either NEXT or PREVIOUS
        if (!target.hasClass('active')) {
            $('.page').removeClass('active');
            target.addClass('active')

            this.last_active_page = this.active_page;

            //Get value of clicked page
            this.active_page = parseInt(target.find('a:first')[0].innerText);

            //If we move to anything OTHER than page 1, we remove the disabled
            //class from the "Previous" button
            if (this.active_page !== 1 && this.active_page !== this.total_pages) {
                $('#previous').removeClass('disabled');
                $('#next').removeClass('disabled');
            } else if (this.active_page === 1) {
                $('#previous').addClass('disabled');
            }

            //If we move to anything OTHER than the last page, we remove the disabled
            //class from the "Next" button
            if (this.active_page !== this.total_pages && this.active_page !== 1) {
                $('#previous').removeClass('disabled');
                $('#next').removeClass('disabled');
            } else if (this.active_page === this.total_pages) {
                $('#next').addClass('disabled');
            }

            this.get_videos();

            this.check_pagination_pages();
        }
    }

    async get_videos() {
        let move_by;
        let next;
        
        //Determine whether we are moving forward or backwards
        if (this.active_page > this.last_active_page) {
            next = true;
            move_by = this.active_page - this.last_active_page;

        } else {
            next = false;
            move_by = this.last_active_page - this.active_page;
        }

        let token = next ? this.next_page_token : this.previous_page_token;

        if(move_by === 0) {
            move_by = 1;
        }

        //Wait for the AJAX request to complete
        let response = await access_server('GET', "api/video-search-pagination", {search_term: this.search_term, number_of_videos: this.number_of_videos, move_by: move_by, next: next, token: token});
        this.update_pagination_data(response.data.data.next_page_token, response.data.data.previous_page_token, response.data.data.total_pages);
        add_video_cards(response.data.data.videos);
    }

    async update_pagination_data(next_page_token, previous_page_token, total_pages) {
        this.next_page_token = next_page_token;
        this.previous_page_token = previous_page_token;
        this.total_pages = total_pages;
    }

    /*
     * A function that updates the 'Home' object with the data from the database
     * 
     * @param {Object} data - An object containing all the data from the database, here we use it to update the 'Home' object
     * 
     * @returns {N/A}
     */
    update_parent_object(data) {
        let service_data = data.services_data;
        let project_data = data.projects_data;
        let category_data = data.categories_data;

        this.services = service_data.map((service_entry) => {
            return new Service(service_entry.id, service_entry.service, service_entry.service_description);
        });

        this.projects = project_data.map((project_entry) => {
            return new Project(project_entry.id, null, project_entry.project_title, null, project_entry.project_image, null, null, null, null, null, project_entry.service, project_entry.category);
        });

        this.categories = category_data.map((category_entry) => {
            return new Category(category_entry.id, category_entry.category);
        });
    }
}

export {Pagination}