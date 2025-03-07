import React from 'react';
import CustomHeader from '@/Layouts/CustomHeader';
import { Link, useForm, usePage } from '@inertiajs/react';
import {
    ChakraProvider,
    defaultSystem,
    Text,
    Box,
    Table,
    Image,
    HStack,
    StackSeparator,
    Button,
    Center,
    Input,
    NativeSelectRoot,
    NativeSelectField,
    VStack,
    Stack,
    Alert
} from '@chakra-ui/react';
import {
    DialogActionTrigger,
    DialogBody,
    DialogCloseTrigger,
    DialogContent,
    DialogFooter,
    DialogHeader,
    DialogRoot,
    DialogTitle,
    DialogTrigger,
  } from "../../../../src/components/ui/dialog"
import { Field } from '../../../../src/components/ui/field';

const MEvents = ({m_events}) => {

    const form = useForm();
    //　削除イベント処理
    const handleDelete = (id, e) => {
        console.log('削除処理');
        console.log(id);
        // 再レンダリング防止
        e.preventDefault();

        // form.delete(`/m_events/delete/${m_event.id}`);
        form.delete(route('e_event.destroy', id));
    }

    return (
        <ChakraProvider value={defaultSystem}>
        <>
            <CustomHeader />

            {/* メイン */}
                <Box className='main' width="90%" m="auto" bg='white' marginTop='20px' boxShadow='md' >
                    <HStack bg='gray.400' color='white'>
                        <Text textStyle={'2xl'} m='20px'>種目マスタ一覧</Text>

                        {/* 検索フォーム */}
                        <DialogRoot>
                            <DialogTrigger asChild>
                                <Button variant="outline" size="xxl" bg="gray.800" p='0.5rem'>
                                検索
                                </Button>
                            </DialogTrigger>
                                <DialogContent>
                                    <DialogHeader>
                                        <Center>
                                            <DialogTitle>種目マスタ検索</DialogTitle>
                                        </Center>
                                    </DialogHeader>
                                    <DialogBody>
                                        <form>
                                            <Stack gap="4">
                                                <Field label="種目名">
                                                    <Input
                                                        placeholder='種目名を入力してください'
                                                        type='text'
                                                        id='team_name'
                                                        name='team_name'
                                                        value={FormData.team_name}
                                                    />
                                                </Field>
                                            </Stack>
                                        </form>
                                    </DialogBody>
                                    <DialogFooter>
                                        {/* <DialogActionTrigger asChild>
                                            <Button variant="outline" color='white' bg='gray.500' size='lg' p='5' width='30%'>閉じる</Button>
                                        </DialogActionTrigger> */}
                                        <Button as={Link} href={`/teams`} color='white' bg='gray.500' size='lg' p='5' width='30%'>リセット</Button>
                                        <Button type='submit' color='white' bg='orange.500' size='lg' p='5' width='30%'>検索</Button>
                                    </DialogFooter>
                                <DialogCloseTrigger />
                            </DialogContent>
                        </DialogRoot>

                        {/* 登録フォーム */}
                        <Button as={Link} href={`/m_events/create`} bg='orange.400' p="0.5rem">
                            種目マスタを登録する
                        </Button>

                    </HStack>

                    {/* テーブル */}
                    {/* <Box w="90%" m="auto" marginBottom="10px" h="58vh" border="1px solid" borderColor="gray.200" p="1rem"> */}
                    <Table.ScrollArea w="90%" m="auto" marginY="2rem" h="70vh" border="1px solid" borderColor="gray.200" p="1rem">
                    <Table.Root>
                        <Table.Header position="sticky" top="0" zIndex="1" bg='gray.400'>
                            <Table.Row>
                                <Table.ColumnHeader borderBottom="2px solid" borderColor="gray.400" textAlign='center' w='60%' fontSize={'md'}>種目名</Table.ColumnHeader>
                                <Table.ColumnHeader borderBottom="2px solid" borderColor="gray.400" textAlign='center' fontSize={'md'}>編集</Table.ColumnHeader>
                                <Table.ColumnHeader borderBottom="2px solid" borderColor="gray.400" textAlign='center' fontSize={'md'}>削除</Table.ColumnHeader>
                            </Table.Row>
                        </Table.Header>

                            <Table.Body>
                                {m_events.map((m_event, index) => (
                                    <Table.Row key={index}>
                                        <Table.Cell textAlign='center'  borderBottom="1px solid" borderColor="gray.300">{m_event.event_name}</Table.Cell>
                                        <Table.Cell  borderBottom="1px solid" borderColor="gray.300">
                                            <Link variant='plain' href={`/m_events/edit/${m_event.id}`}>
                                                <Center>
                                                    <Image src="img/edit.png" />
                                                </Center>
                                            </Link>
                                        </Table.Cell>
                                        <Table.Cell  borderBottom="1px solid" borderColor="gray.300">
                                                <Center>
                                                    <Button onClick={ (e) => handleDelete(m_event.id, e) }>
                                                        <Image src="img/delete.png" />
                                                    </Button>
                                                </Center>
                                        </Table.Cell>
                                    </Table.Row>
                                ))}
                            </Table.Body>

                    </Table.Root>
                    </Table.ScrollArea>
                    {/* </Box> */}

                </Box>

        </>
        </ChakraProvider>
    );
}

export default MEvents;
