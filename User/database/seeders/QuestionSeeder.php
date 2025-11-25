<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Question;
use App\Models\Category;
use App\Models\Level;

class QuestionSeeder extends Seeder
{
    public function run(): void
    {
        // Fetch the required categories and levels
        $categories = [
            'SQA' => Category::firstOrCreate(['name' => 'SQA']),
            'Networking' => Category::firstOrCreate(['name' => 'Networking'])
        ];

        $levels = [
            'Basic' => Level::firstOrCreate(['name' => 'Basic']),
            'Intermediate' => Level::firstOrCreate(['name' => 'Intermediate']),
            'Advanced' => Level::firstOrCreate(['name' => 'Advanced'])
        ];

        // SQA Questions
        $questions_sqa = [
            // Basic SQA Questions
            ['What is Software Quality Assurance?', 'Basic', 'SQA'],
            ['Which of the following is NOT a phase in the software testing lifecycle?', 'Basic', 'SQA'],
            ['What is the main purpose of unit testing?', 'Basic', 'SQA'],
            ['What is the difference between verification and validation in testing?', 'Basic', 'SQA'],
            ['What is a defect in the context of software quality?', 'Basic', 'SQA'],
            ['What does the term “bug” refer to in software testing?', 'Basic', 'SQA'],
            ['Which of the following tools is used for automated testing?', 'Basic', 'SQA'],
            ['What is a test case?', 'Basic', 'SQA'],
            ['What is the purpose of a test plan?', 'Basic', 'SQA'],
            ['What is regression testing?', 'Basic', 'SQA'],
            ['What is load testing in software quality assurance?', 'Basic', 'SQA'],
            ['Which type of testing is performed without looking at the source code?', 'Basic', 'SQA'],
            ['What is the difference between a test script and a test case?', 'Basic', 'SQA'],
            ['What is the purpose of exploratory testing?', 'Basic', 'SQA'],
            ['What is performance testing?', 'Basic', 'SQA'],

            // Intermediate SQA Questions
            ['What is the purpose of static analysis in software testing?', 'Intermediate', 'SQA'],
            ['What is the difference between black-box testing and white-box testing?', 'Intermediate', 'SQA'],
            ['Which testing methodology involves testing the system as a whole?', 'Intermediate', 'SQA'],
            ['What is the role of a test manager?', 'Intermediate', 'SQA'],
            ['What is the difference between stress testing and performance testing?', 'Intermediate', 'SQA'],
            ['What is a use case in software testing?', 'Intermediate', 'SQA'],
            ['What is a test suite?', 'Intermediate', 'SQA'],
            ['Which type of testing is conducted by end-users?', 'Intermediate', 'SQA'],
            ['What is the purpose of the bug tracking system?', 'Intermediate', 'SQA'],
            ['What is acceptance testing?', 'Intermediate', 'SQA'],
            ['What is a test environment?', 'Intermediate', 'SQA'],
            ['Which software development methodology emphasizes continuous integration and testing?', 'Intermediate', 'SQA'],
            ['What is the purpose of the V-Model in software testing?', 'Intermediate', 'SQA'],
            ['What is test automation?', 'Intermediate', 'SQA'],
            ['What are the benefits of using test-driven development (TDD)?', 'Intermediate', 'SQA'],

            // Advanced SQA Questions
            ['What is the difference between a defect density and a defect priority?', 'Advanced', 'SQA'],
            ['What is the purpose of a risk-based testing approach?', 'Advanced', 'SQA'],
            ['What is the role of a test architect?', 'Advanced', 'SQA'],
            ['What is pair testing in software quality assurance?', 'Advanced', 'SQA'],
            ['What is the purpose of code coverage analysis?', 'Advanced', 'SQA'],
            ['What is the significance of the “boundary value analysis” technique?', 'Advanced', 'SQA'],
            ['What is the purpose of root cause analysis in software testing?', 'Advanced', 'SQA'],
            ['What is a performance bottleneck?', 'Advanced', 'SQA'],
            ['What is the importance of test metrics in software quality assurance?', 'Advanced', 'SQA'],
            ['What is the difference between validation and qualification in software quality?', 'Advanced', 'SQA'],
            ['What is a risk mitigation strategy in software testing?', 'Advanced', 'SQA'],
            ['What is the concept of continuous testing in Agile development?', 'Advanced', 'SQA'],
            ['What is a test-driven development (TDD) approach to code writing?', 'Advanced', 'SQA'],
            ['What is a software quality model?', 'Advanced', 'SQA'],
            ['What is a software testing maturity model (TMM)?', 'Advanced', 'SQA'],
        ];

        // Networking Questions
        $questions_networking = [
            // Basic Networking Questions
            ['What is a network?', 'Basic', 'Networking'],
            ['What does "IP" stand for in networking?', 'Basic', 'Networking'],
            ['Which device connects multiple networks together?', 'Basic', 'Networking'],
            ['What is the primary purpose of a firewall?', 'Basic', 'Networking'],
            ['What is the basic unit of data transmission in a network?', 'Basic', 'Networking'],
            ['Which protocol is used to send emails?', 'Basic', 'Networking'],
            ['What does LAN stand for?', 'Basic', 'Networking'],
            ['Which layer of the OSI model handles data encryption?', 'Basic', 'Networking'],
            ['What is the function of a DNS server?', 'Basic', 'Networking'],
            ['What is the default subnet mask for a Class C network?', 'Basic', 'Networking'],
            ['What does the "ping" command test in a network?', 'Basic', 'Networking'],
            ['Which protocol is used for secure communication over the internet?', 'Basic', 'Networking'],
            ['What type of address is 192.168.0.1?', 'Basic', 'Networking'],
            ['Which device operates at the Data Link layer of the OSI model?', 'Basic', 'Networking'],
            ['Which topology connects all devices to a single central device?', 'Basic', 'Networking'],

            // Intermediate Networking Questions
            ['What is the default subnet mask for a Class B IP address?', 'Intermediate', 'Networking'],
            ['Which layer of the OSI model is responsible for end-to-end communication?', 'Intermediate', 'Networking'],
            ['What is the purpose of the Address Resolution Protocol (ARP)?', 'Intermediate', 'Networking'],
            ['In IPv6, how many bits are there in an address?', 'Intermediate', 'Networking'],
            ['What does VLAN stand for?', 'Intermediate', 'Networking'],
            ['What is the function of a router?', 'Intermediate', 'Networking'],
            ['Which protocol is used to dynamically assign IP addresses to devices?', 'Intermediate', 'Networking'],
            ['What is the main purpose of a firewall?', 'Intermediate', 'Networking'],
            ['What is the difference between TCP and UDP?', 'Intermediate', 'Networking'],
            ['Which command is used to display the routing table in Windows?', 'Intermediate', 'Networking'],
            ['What is the main purpose of NAT (Network Address Translation)?', 'Intermediate', 'Networking'],
            ['Which protocol is used to securely transfer files?', 'Intermediate', 'Networking'],
            ['What is the range of private IP addresses for Class C?', 'Intermediate', 'Networking'],
            ['Which layer of the OSI model uses MAC addresses?', 'Intermediate', 'Networking'],
            ['What is DNS (Domain Name System)?', 'Intermediate', 'Networking'],

            // Advanced Networking Questions
            ['What is the primary purpose of a subnet mask in networking?', 'Advanced', 'Networking'],
            ['Which routing protocol is best suited for a large-scale enterprise network?', 'Advanced', 'Networking'],
            ['What is the main difference between TCP and UDP?', 'Advanced', 'Networking'],
            ['How does NAT (Network Address Translation) work?', 'Advanced', 'Networking'],
            ['What is the function of ARP in a network?', 'Advanced', 'Networking'],
            ['In a VLAN setup, what is the primary function of a trunk port?', 'Advanced', 'Networking'],
            ['What does the term "spanning tree protocol" (STP) aim to prevent in a switched network?', 'Advanced', 'Networking'],
            ['What is the primary difference between IPv4 and IPv6?', 'Advanced', 'Networking'],
            ['What is a characteristic of SDN (Software-Defined Networking)?', 'Advanced', 'Networking'],
            ['How does a firewall inspect network traffic?', 'Advanced', 'Networking'],
            ['What is the main benefit of using MPLS in a network?', 'Advanced', 'Networking'],
            ['What is the key advantage of using IPv6 over IPv4?', 'Advanced', 'Networking'],
            ['Which command would you use to test DNS resolution in a network?', 'Advanced', 'Networking'],
            ['What does QoS (Quality of Service) prioritize in a network?', 'Advanced', 'Networking'],
            ['What is the purpose of the 802.1X protocol in networking?', 'Advanced', 'Networking']
        ];

        // Insert SQA questions
        foreach ($questions_sqa as [$question_text, $level_name, $category_name]) {
            $category = $categories[$category_name];
            $level = $levels[$level_name];

            if ($category && $level) {
                Question::create([
                    'category_id' => $category->id,
                    'level_id' => $level->id,
                    'question_text' => $question_text,
                    'type' => 'text',
                ]);
            }
        }

        // Insert Networking questions
        foreach ($questions_networking as [$question_text, $level_name, $category_name]) {
            $category = $categories[$category_name];
            $level = $levels[$level_name];

            if ($category && $level) {
                Question::create([
                    'category_id' => $category->id,
                    'level_id' => $level->id,
                    'question_text' => $question_text,
                    'type' => 'text',
                ]);
            }
        }
    }
}