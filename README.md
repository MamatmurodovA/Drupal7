INSTALL
    Create content type
        structure:
            type = forum_topic
            fields = {
                {
                    {machine name:title} => { title: 'Topic', type: 'textfield'}
                },
                {
                    {machine name:body} => { title: 'Topic description', type: 'body'}
                },
                {
                    {machine name:field_forum_sections} => { title: 'Category', type: 'taxonomy term references'}
                },
                {
                    {machine name:field_seen} => {title : 'Seen', type: 'integer'}
                }
            }
    Create taxonomy:
        structure:
            machine name = forums
  