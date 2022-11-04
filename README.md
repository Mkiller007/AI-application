The application I developed offers its users to write, read and modify messages while being assisted by AI. 

It is coded in PHP and uses the GPT and Stable-Diffusion models.

The GPT part helps with features such as:
  Summarizing messages.
  Extracting relevant ideas from messages.

The Stable-Diffusion template allows to:
  Generate a single cover image for your articles.
  Generate images from any article in the platform.
  
My code follows the MVC architecture.

  Model: I implemented a Post class ('App/Models/Post') to define methods to manipulate an article to summarize it, extract ideas and generate images.
  These methods allow us to call the APIs given by Stable-Diffusion and GPT.

  View: The views folder ('resources/views') contains the HTML code of our web application pages. 
  The routes folder executes the methods of the Route class to send requests to the controllers based on the URL.

  Controller: The controllers folder ('App/Http/Controllers') contains the methods to modify our Post objects based on the input given in the URL.
