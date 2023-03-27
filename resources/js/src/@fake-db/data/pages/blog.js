import mock from '@/@fake-db/mock'
/* eslint-disable global-require */
const data = {
    // blog list
    blogSidebar: {
        categories: [
            {category: 'Posting Specs', icon: 'WatchIcon'},
            {category: 'POST', icon: 'CommandIcon'},
            {category: 'Response', icon: 'ShoppingCartIcon'},
        ],
    },

    // detail
    blogDetail: {
        blog: {
            img: require('@/assets/images/banner/banner-12.jpg'),
            title: 'UPING accepts applications through HTTP POST',
            avatar: require('@/assets/images/portrait/small/avatar-s-7.jpg'),
            userFullName: 'UPING',
            createdTime: 'Mar 12, 2022',
            tags: ['JSON', 'XML'],
            content:
                '<p>UPING accepts applications through HTTP POST..</p>' +
                '<p>Lead generators are required to send the lead via HTTP POST in JSON format to the endpoint\n' +
                '                        below:</p>\n' +
                '                    <br>\n' +
                '\n' +
                '                    <p><h6 class="grade chip">https://www.portal.uping.co.uk/leads/application/post</h6></p>' +
                '     <h4>Unprecedented Challenge</h4' +
                '><ul class="mb-2">' +
                ' <li>Preliminary thinking systems</li>' +
                '<li>Bandwidth efficient</li>' +
                '<li>Green space</li>' +
                '<li>Social impact</li>' +
                '<li>Thought partnership</li>' +
                '<li>Fully ethical life</li>' +
                '</ul>  ',
            // comments: 19100,
            // bookmarked: 139,
            UserComment: [
                {
                    avatar: require('@/assets/images/portrait/small/avatar-s-6.jpg'),
                    fullName: 'Willie Clark',
                    comment:
                        'Based in London, Uncode is a blog by Willie Clark. His posts explore modern design trends through photos and quotes by influential creatives and web designer around the world.',
                },
            ],
        },
        comments: [
            {
                avatar: require('@/assets/images/portrait/small/avatar-s-9.jpg'),
                userFullName: 'POST',
                commentedAt: 'May 24, 2020',
                commentText:
                    'A variation on the question technique above, the multiple-choice question great way to engage your reader.',
            },
            {
                avatar: require('@/assets/images/portrait/small/avatar-s-9.jpg'),
                userFullName: 'RESPONSE',
                commentedAt: 'May 24, 2020',
                commentText:
                    'A variation on the question technique above, the multiple-choice question great way to engage your reader.',
            },
            {
                avatar: require('@/assets/images/portrait/small/avatar-s-9.jpg'),
                userFullName: 'RESPONSE',
                commentedAt: 'May 24, 2020',
                commentText:
                    'A variation on the question technique above, the multiple-choice question great way to engage your reader.',
            },
            {
                avatar: require('@/assets/images/portrait/small/avatar-s-9.jpg'),
                userFullName: 'RESPONSE',
                commentedAt: 'May 24, 2020',
                commentText:
                    'A variation on the question technique above, the multiple-choice question great way to engage your reader.',
            },
        ],
    },

}
/* eslint-disable global-require */
mock.onGet('/blog/list/data/sidebar').reply(() => [200, data.blogSidebar])
mock.onGet('/blog/list/data/detail').reply(() => [200, data.blogDetail])
