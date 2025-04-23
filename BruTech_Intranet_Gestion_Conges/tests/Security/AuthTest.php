// tests/Security/Auth.php

namespace App\Tests\Security;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AuthTest extends WebTestCase
{
    // Test for employee login
    public function testEmployeeLogin()
    {
        // Create a client to interact with the Symfony app
        $client = static::createClient();
        
        // Make a GET request to the login page
        $crawler = $client->request('GET', '/login');
        
        // Debug: Print the HTML to ensure it's correct (optional)
        // echo $crawler->html(); 
        
        // Assert the page is displayed correctly (status code 200)
        $this->assertResponseIsSuccessful();

        // Find the login form and submit it
        $form = $crawler->selectButton('Se connecter')->form([
            'username' => 'employee',  // Replace with actual username for the test
            'password' => 'password'   // Replace with actual password for the test
        ]);
        
        // Submit the form
        $client->submit($form);

        // Assert that the user is redirected after login (e.g., to the dashboard)
        $this->assertResponseRedirects('/dashboard');
        
        // You can also test if the correct page content is rendered after login
        $crawler = $client->followRedirect();
        $this->assertStringContainsString('Welcome to the dashboard', $crawler->text());
    }

    // Test for manager login
    public function testManagerLogin()
    {
        // Create a client to interact with the Symfony app
        $client = static::createClient();

        // Make a GET request to the login page
        $crawler = $client->request('GET', '/login');
        $this->assertResponseIsSuccessful(); // Check if the response is successful

        // Find the login form and submit it
        $form = $crawler->selectButton('Se connecter')->form([
            'username' => 'manager',  // Replace with manager username for the test
            'password' => 'managerpassword' // Replace with manager password for the test
        ]);
        $client->submit($form);

        // Assert that the user is redirected after login (e.g., to the manager dashboard)
        $this->assertResponseRedirects('/manager-dashboard');
    }

    // Test for access denied for employee
    public function testAccessDeniedForEmployee()
    {
        // Create a client to interact with the Symfony app
        $client = static::createClient();

        // Try accessing a page that should be restricted for regular employees
        $crawler = $client->request('GET', '/restricted-area');
        
        // Assert that access is denied (e.g., 403 Forbidden)
        $this->assertResponseStatusCodeSame(403);
    }
}
